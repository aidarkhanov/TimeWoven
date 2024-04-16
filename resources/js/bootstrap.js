import axios from 'axios';
import Alpine from 'alpinejs';
import Cropper from 'cropperjs';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = Alpine;
window.Cropper = Cropper;

window.timezoneDetector = (timezone) => ({
    timezone,
    detectTimezone() {
        this.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById('timezone').value = this.timezone;
    }
});

/**
 * Initializes an image cropping tool that handles cropping inside a modal.
 * It processes only JPG and PNG files.
 *
 * @param {string} modalName - Identifier for the modal dialog used for cropping.
 * @returns {Object} An interface with methods to manage image cropping operations.
 */
window.imageCropper = (modalName) => ({
    modalName,
    cropper: null,
    imageBase64: '',
    croppedImageBase64: '',

    /**
     * Handles file selection by reading the file as a data URL and preparing it for cropping.
     * Validates file type and initiates the modal upon successful image load.
     *
     * @param {Event} fileEvent - Triggered by file input selection.
     */
    onFileSelect(fileEvent) {
        const file = fileEvent.target.files[0];
        if (!this.isValidFileType(file?.type)) {
            alert('Only JPEG and PNG files are accepted.');
            return;
        }

        this.cleanup();

        const reader = new FileReader();
        reader.addEventListener('load', ({ target }) => {
            this.imageBase64 = target.result;
            this.openModal();
        });
        reader.readAsDataURL(file);
    },

    /**
     * Crops the image, extracting it in PNG format, and cleans up resources.
     */
    cropImage() {
        if (!this.cropper) return;

        this.croppedImageBase64 = this.cropper.getCroppedCanvas({ fillColor: '#ffffff' }).toDataURL('image/png');
        this.closeModal();
    },

    /**
     * Dispatches an event to close the modal and performs cleanup.
     */
    closeModal() {
        console.log('I am called to close!');
        dispatchEvent(new CustomEvent('close-modal', { detail: this.modalName }));
        this.cleanup();
    },

    /**
     * Opens the modal and initializes the cropper after ensuring the modal is visible.
     */
    openModal() {
        dispatchEvent(new CustomEvent('open-modal', { detail: this.modalName }));
        this.$nextTick(() => this.initCropper());
    },

    /**
     * Sets up a Cropper instance on a newly created image element loaded with the selected image.
     */
    initCropper() {
        const container = document.getElementById('cropperContainer');
        if (!container) return;

        container.replaceChildren();

        const imageElement = document.createElement('img');
        imageElement.addEventListener('load', ({ target }) => {
            this.cropper = new Cropper(target, {
                aspectRatio: 1,
                viewMode: 1,
            });
        });
        imageElement.src = this.imageBase64;

        container.appendChild(imageElement);
    },

    /**
     * Validates if the file type is either JPEG or PNG.
     *
     * @param {string} type - MIME type of the file.
     * @returns {boolean} True if supported, false otherwise.
     */
    isValidFileType(type) {
        return ['image/jpeg', 'image/png'].includes(type);
    },

    /**
     * Clears all resources used by the cropper and resets the state.
     */
    cleanup() {
        const container = document.getElementById('cropperContainer');
        if (container) container.replaceChildren();

        this.destroyCropper();
        this.imageBase64 = '';
    },

    /**
     * Destroys the Cropper instance safely.
     */
    destroyCropper() {
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
    },

    /**
     * Resets all internal states, typically used when a new image is loaded or an error occurs.
     */
    reset() {
        this.destroyCropper();
        this.imageBase64 = '';
        this.croppedImageBase64 = '';
    },
});
