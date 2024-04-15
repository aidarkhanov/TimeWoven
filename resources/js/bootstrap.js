import axios from 'axios';
import Alpine from 'alpinejs';
import Cropper from "cropperjs";

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Alpine = Alpine;
window.Cropper = Cropper;

window.timezoneDetector = (timezone) => {
    return {
        timezone,
        detectTimezone() {
            this.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = this.timezone;
        }
    }
};

window.imageCropper = (modalName) => ({
    modalName,
    imageSrc: '',
    croppedImage: '',
    croppedImageSrc: '',

    initCropper() {
        this.$nextTick(() => {
            const container = document.getElementById('cropperContainer');
            if (container && this.imageSrc) {
                container.innerHTML = '';

                const imageElement = document.createElement('img');
                imageElement.src = this.imageSrc;
                container.appendChild(imageElement);

                this.cropper = new Cropper(imageElement, {
                    aspectRatio: 1,
                    viewMode: 1,
                });
            }
        });
    },

    openModal() {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: this.modalName }));
        this.initCropper();
    },

    closeModal() {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: this.modalName }));
        this.cleanup();
    },

    cropImage() {
        if (this.cropper) {
            this.croppedImage = this.cropper
                .getCroppedCanvas({ fillColor: '#ffffff' })
                .toDataURL('image/png');
            this.croppedImageSrc = this.croppedImage;

            this.cropper.destroy();
            this.closeModal();
            this.cleanup();
        }
    },

    cleanup() {
        const container = document.getElementById('cropperContainer');
        if (container) {
            container.innerHTML = '';
        }
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
        this.imageSrc = '';
    },

    onFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.cleanup();
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageSrc = e.target.result;
                this.openModal();
            };
            reader.readAsDataURL(file);
        } else {
            this.imageSrc = '';
            this.croppedImage = '';
            this.croppedImageSrc = '';
        }
    },
});
