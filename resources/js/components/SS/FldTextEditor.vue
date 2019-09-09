/**

For text editor
=====================

<fld-text-editor
    name="description"
    v-model="form_data.description"
/>

*/

<template>

    <!-- <textarea
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)">

    </textarea> -->
    <ckeditor
        :name="this.name"
        :id="'field_' + this.name"
        :editor="editor"
        v-model="editorData"
        :config="editorConfig"
        tag-name="textarea"
        v-on:input="$emit('input', editorData)"
    ></ckeditor>

</template>

<script>
    // Documentation at https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/frameworks/vuejs.html
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        name: 'fld-text-editor',
        props: {
            'params': {
                type: Object,
                default: function () {
                }
            },
            value: {
                default: null
            },
            name: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                editor: ClassicEditor,
                editorData: this.value,
                editorConfig: {
                    toolbar: [
                        "heading",
                        "bold",
                        "italic",
                        "link",
                        "bulletedList",
                        "numberedList",
                        //"ckfinder",
                        //"imageTextAlternative",
                        // TODO: turn this on later: "imageUpload",
                        //"imageStyle:full",
                        //"imageStyle:side",
                        "blockQuote",
                        "insertTable",
                        //"tableColumn",
                        //"tableRow",
                        //"mergeTableCells",
                        // TODO: turn this on later: "mediaEmbed",
                        "undo",
                        "redo",
                    ]
                }
            }
        }
    }

    /*
    // For development/reference, to get the list of available toolbar items:
    var editor = ClassicEditor
        .create(document.querySelector('input[name="name"]'))
        .then(function(editor){
            console.log(Array.from(editor.ui.componentFactory.names()));
        });
     */
</script>
