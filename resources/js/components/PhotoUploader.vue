//  For some reason this component could not be found with the style in it
//     See https://github.com/JeffreyWay/laravel-mix/issues/2064

// From  https://github.com/charliekassel/vuejs-uploader

<template>

    <div class="vuejs-uploader"
         @drop.stop.prevent="dropFiles"
         @dragover.stop.prevent="dragover"
         @dragleave="dragleave"
         :class="{'vuejs-uploader--dragged' : isDraggedOver && !isBrowseDisabled}">

        <label :class="{'disabled': isBrowseDisabled}">
      <span v-if="isSingleFileUpload">
        <!-- Customisable slot for single file uploads -->
        <slot name="browse-btn">
          <span class="vuejs-uploader__btn">Add Up 3 Photos</span>
        </slot>

        <p class="vuejs-uploader__error" v-if="files[0] && hasError(files[0]) && showErrors">{{ handleError(files[0].error) }}</p>

        <div v-if="showProgressBar && files[0]" class="vuejs-uploader__progress">
          <div class="vuejs-uploader__progress-bar" :style="progressBarStyle(files[0])"></div>
        </div>
      </span>
      <span v-if="isMultipleFileUpload">
        <slot v-if="this.files.length < this.maxUploads" name="browse-btn">
          <span class="vuejs-uploader__btn">Add Up to 3 Photos</span>
        </slot>
      </span>
            <!-- File Input -->
            <input type="file" :disabled="isBrowseDisabled"
                   :multiple="multiple"
                   :accept="accept"
                   @change="selectFiles"
                   accept="application/vnd.ms-excel">
        </label>

        <!--
            <span v-if="isMultipleFileUpload">
              <button type="button" class="vuejs-uploader__btn vuejs-uploader__btn--clear" @click="clear" :disabled="noFiles">
                <slot name="clear-btn">Clear</slot>
              </button>
              <button type="button" class="vuejs-uploader__btn vuejs-uploader__btn--upload" @click="upload" :disabled="isUploadDisabled" :class="{'vuejs-uploader__btn--ready' : hasFiles}">
                <slot name="upload-btn">Upload</slot>
              </button>
            </span>
        -->
        <!-- Errors -->
        <div v-if="errorMessage" class="vuejs-uploader__error">{{ errorMessage }}</div>

        <!-- File list -->
        <ul class="vuejs-uploader__queue" v-if="isMultipleFileUpload">
            <li v-for="(fileObj, i) in this.files" class="vuejs-uploader__file" :key="i">
                <div class="vuejs-uploader__file--preview">
                    <div class="loading" v-if="isImageUpload(fileObj) && !fileObj.image"></div>
                    <img :src="fileObj.image" v-if="fileObj.image"/>

                    <span v-if="!isImageUpload(fileObj)" class="vuejs-uploader__file-icon" :class="fileObj.extension">{{ fileObj.extension }}</span>

                </div>
                <div class="vuejs-uploader__file--meta">
                    <slot name="extra" :fileObj="fileObj"></slot>

                    <p class="vuejs-uploader__file--filename">{{ fileObj.file.name }}</p>

                    <p v-if="fileObj.error && showErrors">{{ handleError(fileObj.error) }}</p>


                    <div class="vuejs-uploader__progress">
                        <div class="vuejs-uploader__progress-bar" :style="progressBarStyle(fileObj)"></div>
                    </div>

                </div>
                <div>
                    <button type="button" class="vuejs-uploader__btn vuejs-uploader__btn--delete"
                            @click="removeFile(fileObj)">
                        <slot name="remove-btn">Remove</slot>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    /**
     * @TODO
     * Allow axios config to be passed via prop
     * Investigate sending files with fetch instead of axios
     * Listen for 429 header then setTimeout to Retry-after header
     * Debug cleanQueue method
     */
    import axios from 'axios'
    import FileUpload from '../FileUpload'
    import ImageUpload from '../ImageUpload'

    export default {
        name: "photo-uploader",
        props: {

            /**
             * Save flag from parent
             */
            saveImages: {
                type: Number
            },
            displayName: {
                type: String
            },

            /**
             * Server end point to send files to
             */
            endPoint: {
                type: String,
                required: true
            },

            /**
             * Headers
             */
            headers: Object,

            /**
             * Error handler
             */
            showErrors: {
                type: Boolean,
                default: true
            },

            /**
             * Accept list of mimes
             */
            accept: String,

            /**
             * Upload multiple files at once
             */
            multiple: Boolean,

            /**
             * Upload larger files as multipart uploads?
             */
            multipart: Boolean,

            /**
             * Multipart upload chunk size
             */
            multipartChunkSize: {
                type: Number,
                default: 1024 * 1024 * 2 // 2mb
            },

            /**
             * Number of files that can be added to the queue
             */
            maxUploads: {
                type: Number,
                default: 5
            },

            /**
             * Maximun preview image width
             */
            maxThumbWidth: {
                type: Number,
                default: 80
            },

            /**
             * Maximun preview image height
             */
            maxThumbHeight: {
                type: Number,
                default: 80
            },

            /**
             * Array of additional data properties to add to the FileObj
             */
            userDefinedProperties: Array,

            /**
             * Show progress bar for single file uploads (shows by default for multiple file uploads)
             */
            showProgressBar: {
                type: Boolean,
                default: false
            },

            /**
             * Disable uploading
             */
            disabled: Boolean
        },
        data() {
            return {
                files: [],
                errorMessage: null,
                isDraggedOver: null,
                upLoadStarted: false
            }
        },
        watch: {
            saveImages: function () {
                this.upload();
            },

            files: function () {
                this.$emit('fileCount',this.files.length);
                if (this.upLoadStarted == true && !this.files[0]) {
                    this.$emit('uploaded');
                }
            }
        },
        computed: {
            getFiles() {
                return this.files
            },
            hasFiles() {
                return !this.noFiles
            },
            isSingleFileUpload() {
                return !this.multiple
            },
            isMultipleFileUpload() {
                return this.multiple
            },
            isMultipartUpload() {
                return this.multipart
            },
            isBrowseDisabled() {
                return this.disabled
            },
            isUploadDisabled() {
                let completeRequired = true
                if (this.userDefinedProperties) {
                    this.userDefinedProperties.forEach(prop => {
                        this.files.forEach(file => {
                            if (prop.required && !file[prop.property]) {
                                completeRequired = false
                            }
                        })
                    })
                }
                return !this.files.length || !completeRequired
            },
            noFiles() {
                return this.files.length === 0
            }
        },
        methods: {
            dragover() {
                this.isDraggedOver = true
            },
            dragleave() {
                this.isDraggedOver = false
            },
            /**
             * Initiate the upload
             */
            upload() {
                if (this.isUploadDisabled) {
                    this.$emit('uploaded');
                    return false;
                }

                this.resetError()
                this.upLoadStarted = true
                this.files.forEach(file => this.uploadFile(file))

            },

            /**
             * Empty the file upload queue
             */
            clear() {
                this.resetError()
                this.files = []
            },

            /**
             * Is the file to be uploaded an image?
             * @param {FileUpload}
             * @return {Boolean}
             */
            isImageUpload(fileObj) {
                return fileObj.hasOwnProperty('image')
            },

            /**
             * Is the file an Image?
             *
             * @param {File} file
             * @return {Boolean}
             */
            isImage(file) {
                return ['image/jpeg', 'image/png', 'image/gif'].includes(file.type)
            },

            /**
             * Upload a single file
             *
             * @param  {FileUpload} fileObj
             * @return {Promise}
             */
            uploadFile(fileObj) {


                if (fileObj.isUploading) {
                    return false
                }
                // adds a flag to prevent attempting to
                // upload the same file multiple times.
                fileObj.isUploading = true

                if (this.multipart && fileObj.file.size > this.multipartChunkSize) {
                    this.multipartUploadFile(fileObj)
                    return true
                }

                let data = new FormData()
                data.append('file', fileObj.file)
                data.append('work_order_log_id', this.saveImages)
                data.append('display_name', this.displayName)
                data = this.appendUserData(fileObj, data)

                const config = {
                    onUploadProgress: (progressEvent) => {
                        fileObj.setProgress(progressEvent)
                    }
                }


                return axios.post(this.endPoint, data, config)
                    .then((response) => {

                        this.$emit('fileUploaded', {
                            file: fileObj,
                            response: response.data
                        })
                    })
                    .catch((error) => {

                        this.$emit('error', error)
                        fileObj.error = error.response.data
                    })
            },

            /**
             * Upload a file in chunks
             * This creates an array of parts to be uploaded
             *
             * @param  {FileUpload} fileObj
             */
            multipartUploadFile(fileObj) {


                const totalParts = Math.ceil(fileObj.file.size / this.multipartChunkSize)
                let i = 1
                const queue = []
                do {
                    const currentPart = i
                    const blob = this.getFileChunk(fileObj, currentPart)
                    let data = new FormData()
                    const config = {
                        onUploadProgress: (progressEvent) => {
                            fileObj.setMultipartProgress(progressEvent, totalParts, currentPart)
                        }
                    }
                    data.append('multipart', true)
                    data.append('file', blob)
                    data.append('filename', fileObj.file.name)
                    data.append('mime', fileObj.file.type)
                    data.append('totalSize', fileObj.file.size)
                    data.append('partSize', this.multipartChunkSize)
                    data.append('totalParts', totalParts)
                    data.append('currentPart', currentPart)
                    data.append('work_order_log_id', this.saveImages)
                    data = this.appendUserData(fileObj, data)
                    queue.push({
                        data: data,
                        config: config,
                        fileObj: fileObj,
                        currentPart: currentPart
                    })
                    i++
                } while (i <= totalParts)

                this.processQueue(queue, fileObj)
            },

            /**
             * Process the multipart queue, make one request at a time
             *
             * @param  {Array} queue
             * @param  {FileUpload} fileObj
             * @param  {Object} response
             * @return {Promise}
             */
            processQueue(queue, fileObj, response) {
                queue = this.cleanQueue(queue, fileObj, response)
                if (!queue.length) {
                    this.$emit('fileUploaded', {
                        file: fileObj,
                        response: response.data
                    })


                    return true
                }
                const part = queue.shift()
                return axios.post(this.endPoint, part.data, part.config)
                    .then((response) => {
                        this.$emit('chunkUploaded', part.fileObj, part.currentPart)
                        this.processQueue(queue, fileObj, response)
                    })
                    .catch((error) => {
                        console.error(error)
                        if (error.request && error.request.status === 429) {
                            queue.push(part)
                            setTimeout(function () {
                                this.processQueue()
                            }, 60000) // should be from retry-after header
                        }

                        this.$emit('error', error)
                        part.fileObj.error = error.response.data
                    })
            },

            /**
             * Removes from the queue any parts that have already been uploaded
             * This requires the server response to contain a `remainingParts` property
             * with an array of all remain parts to be uploaded.
             * This is for resumable uploads.
             *
             * @param  {Array} queue
             * @param  {FileUpload} fileObj
             * @param  {Object} response
             * @return {Array}
             */
            cleanQueue(queue, fileObj, response) {
                if (!response) {
                    return queue
                }
                if (response.data.meta && response.data.meta.remainingParts) {
                    return queue.filter(item => {
                        const uploaded = response.data.meta.remainingParts.includes(item.currentPart) === false
                        if (uploaded) {
                            fileObj.uploadedParts.push({
                                part: item.currentPart,
                                loaded: 100
                            })
                        }
                        return !uploaded
                    })
                }
                return queue
            },

            /**
             * Slice a File object into chunks
             *
             * @param  {FileUpload} fileObj
             * @param  {Number} part
             * @return {Blob}
             */
            getFileChunk(fileObj, part) {
                const start = (part - 1) * this.multipartChunkSize
                const end = Math.min((start + this.multipartChunkSize), fileObj.file.size)
                return fileObj.file.slice(start, end)
            },

            /**
             * Add files to the FileList
             */
            selectFiles(event) {
                this.addFiles(event.target.files)
            },

            /**
             * Add files by dropping
             */
            dropFiles(event) {
                this.isDraggedOver = false
                this.addFiles(event.dataTransfer.files)
            },

            /**
             * Add file(s) to the file list
             *
             * @param {FileList}
             */
            addFiles(files) {
                Array.from(files).forEach(file => {
                    if (this.files.length === this.maxUploads) {
                        this.setError('Only ' + this.maxUploads + ' files can be uploaded at one time')
                        return false
                    }
                    if (this.files.findIndex(existingFile => existingFile.file.name === file.name) === -1) {
                        const fileObj = this.uploadFactory(file)
                        this.files.push(fileObj)
                    }
                })
                // start upload if queue is not being used i.e not multiple
                if (!this.multiple) {
                    this.resetError()
                    this.upload()
                    this.$emit('startUpload')
                }

                this.browse = null
            },

            /**
             * Set an error message
             *
             * @param {String} error
             */
            setError(error) {
                this.errorMessage = error
            },

            /**
             * Reset the error message
             */
            resetError() {
                this.errorMessage = null
            },

            /**
             * Returns a FileUpload object
             *
             * @param  {File} file
             * @return {FileUpload|ImageUpload}
             */
            uploadFactory(file) {
                let fileObj
                if (this.isImage(file)) {
                    fileObj = new ImageUpload(file)
                    if (this.isMultipleFileUpload) {
                        this.getPreviewImage(fileObj)
                    }
                } else {
                    fileObj = new FileUpload(file)
                }

                fileObj = this.appendUserProperties(fileObj)

                fileObj.display_name = fileObj.file.name;

                // paul

                return fileObj;
            },

            /**
             * Append user properties to the file obj - useful when adding form elements in the slot
             *
             * @param  {FileUpload} fileObj
             * @return {FileUpload}
             */
            appendUserProperties(fileObj) {
                if (this.userDefinedProperties) {
                    this.userDefinedProperties.forEach(obj => {
                        fileObj[obj.property] = null
                    })
                }
                return fileObj
            },

            /**
             * Add the user defined properties to the FormData object
             *
             * @param  {FileUpload} fileObj
             * @param  {FormData} formData
             * @return {FormData}
             */
            appendUserData(fileObj, formData) {
                if (this.userDefinedProperties) {
                    this.userDefinedProperties.forEach(obj => {
                        formData.append(obj.property, fileObj[obj.property])
                    })
                }
                return formData
            },

            /**
             * Remove file from the file list
             *
             * @param  {File} file
             */
            removeFile(file) {
                this.$el.querySelector('input[type=file]').value = null
                this.resetError()
                const index = this.files.indexOf(file)
                this.files.splice(index, 1)
            },

            /**
             * Get a preview image
             *
             * @param {Object} fileObj
             */
            getPreviewImage(fileObj) {
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.resizeImage(e.target.result, this.maxThumbWidth, this.maxThumbHeight, fileObj)
                }
                reader.readAsDataURL(fileObj.file)
            },

            /**
             * Create resized image.
             * Draw reader result onto resized canvas element then set the dataUri to the ImageUpload.image property
             *
             * @param {String} src
             * @param {Number} maxWidth
             * @param {Number} maxHeight
             * @param {ImageUpload} fileObj
             */
            resizeImage(src, maxWidth, maxHeight, fileObj) {
                const canvas = document.createElement('canvas')
                const img = new Image()
                const ctx = canvas.getContext('2d')
                img.src = src
                img.onload = () => {
                    const resize = this.calculateAspectRatioFit(img.width, img.height, maxWidth, maxHeight)
                    canvas.width = resize.width
                    canvas.height = resize.height
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, canvas.width, canvas.height)
                    fileObj.image = canvas.toDataURL(fileObj.file.type, 0.8)
                }
            },

            /**
             * Conserve aspect ratio of the orignal region. Useful when shrinking/enlarging
             * images to fit into a certain area.
             *
             * @param {Number} srcWidth Source area width
             * @param {Number} srcHeight Source area height
             * @param {Number} maxWidth Fittable area maximum available width
             * @param {Number} maxHeight Fittable area maximum available height
             * @return {Object} { width, heigth }
             */
            calculateAspectRatioFit(srcWidth, srcHeight, maxWidth, maxHeight) {
                const ratio = Math.min(maxWidth / srcWidth, maxHeight / srcHeight)
                return {
                    width: srcWidth * ratio,
                    height: srcHeight * ratio
                }
            },

            /**
             * Style object for the progress bar
             *
             * @param {FileObj}
             * @return {Object}
             */
            progressBarStyle(fileObj) {
                return this.isMultipartUpload && fileObj.filesize > this.multipartChunkSize
                    ? {width: fileObj.multipartUploadPercent + '%'}
                    : {width: fileObj.singlepartUploadPercent + '%'}
            },

            /**
             * Configure axios
             */
            configureHttpClient() {
                const config = {}
                if (this.headers) {
                    config.headers = this.headers
                }
                // this.$http = axios.create(config)
            },

            /**
             * @param  {File}
             * @return {Boolean}
             */
            hasError(file) {
                return Boolean(file.error)
            },

            /**
             * Defer to external error handler if configured else return the error message
             * @param  {Object} error
             * @return {Object}
             */
            handleError(error) {
                return error
            }
        },
        mounted() {
            this.configureHttpClient()
            this.$on('fileUploaded', file => this.removeFile(file))
        }
    }
</script>
