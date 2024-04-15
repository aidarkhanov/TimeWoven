@props(['disabled' => false])

<div
    {!! $attributes->only(['class'])->merge(['class' => 'p-4 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer hover:bg-gray-100']) !!}
    x-bind:class="{'bg-blue-100 border-blue-500': isDragging}"
    x-data="{
        isDragging: false,
        handleDrop($event) {
            this.isDragging = false;
            const files = $event.dataTransfer.files;
            if (files.length > 0) {
                this.$refs.fileInput.files = files;
                this.$refs.fileInput.dispatchEvent(new Event('change'));
            }
        }
    }"
    x-on:dragover.prevent="isDragging = true"
    x-on:dragleave.prevent="isDragging = false"
    x-on:drop.prevent="handleDrop">
    <label class="flex flex-col items-center justify-center space-y-2 cursor-pointer">
        <span class="font-medium text-gray-700">Drag and drop files here or click to select</span>
        <input
            x-ref="fileInput"
            {{ $disabled ? 'disabled' : '' }}
            {!! $attributes->except(['class', 'type'])->merge(['class' => 'hidden', 'type' => 'file']) !!} />
    </label>
</div>
