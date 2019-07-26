(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["fld-text-editor"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
!(function webpackMissingModule() { var e = new Error("Cannot find module '@ckeditor/ckeditor5-build-classic'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
// Documentation at https://ckeditor.com/docs/ckeditor5/latest/builds/guides/integration/frameworks/vuejs.html

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'fld-text-editor',
  props: {
    'params': {
      type: Object,
      default: function _default() {}
    },
    value: {
      default: null
    },
    name: {
      type: String,
      default: ''
    }
  },
  data: function data() {
    return {
      editor: !(function webpackMissingModule() { var e = new Error("Cannot find module '@ckeditor/ckeditor5-build-classic'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
      editorData: this.value,
      editorConfig: {
        toolbar: ["heading", "bold", "italic", "link", "bulletedList", "numberedList", //"ckfinder",
        //"imageTextAlternative",
        // TODO: turn this on later: "imageUpload",
        //"imageStyle:full",
        //"imageStyle:side",
        "blockQuote", "insertTable", //"tableColumn",
        //"tableRow",
        //"mergeTableCells",
        // TODO: turn this on later: "mediaEmbed",
        "undo", "redo"]
      }
    };
  }
});
/*
// For development/reference, to get the list of available toolbar items:
var editor = ClassicEditor
    .create(document.querySelector('input[name="name"]'))
    .then(function(editor){
        console.log(Array.from(editor.ui.componentFactory.names()));
    });
 */

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98& ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("ckeditor", {
    attrs: {
      name: this.name,
      id: "field_" + this.name,
      editor: _vm.editor,
      config: _vm.editorConfig,
      "tag-name": "textarea"
    },
    on: {
      input: function($event) {
        return _vm.$emit("input", _vm.editorData)
      }
    },
    model: {
      value: _vm.editorData,
      callback: function($$v) {
        _vm.editorData = $$v
      },
      expression: "editorData"
    }
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/SS/FldTextEditor.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/SS/FldTextEditor.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FldTextEditor.vue?vue&type=template&id=6e28bf98& */ "./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98&");
/* harmony import */ var _FldTextEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FldTextEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _FldTextEditor_vue_vue_type_custom_index_0_blockType_fld_text_editor_name_description_v_model_form_data_description__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./FldTextEditor.vue?vue&type=custom&index=0&blockType=fld-text-editor&name=description&v-model=form_data.description */ "./resources/js/components/SS/FldTextEditor.vue?vue&type=custom&index=0&blockType=fld-text-editor&name=description&v-model=form_data.description");
/* harmony import */ var _FldTextEditor_vue_vue_type_custom_index_0_blockType_fld_text_editor_name_description_v_model_form_data_description__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_FldTextEditor_vue_vue_type_custom_index_0_blockType_fld_text_editor_name_description_v_model_form_data_description__WEBPACK_IMPORTED_MODULE_3__);





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FldTextEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__["render"],
  _FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* custom blocks */

if (typeof _FldTextEditor_vue_vue_type_custom_index_0_blockType_fld_text_editor_name_description_v_model_form_data_description__WEBPACK_IMPORTED_MODULE_3___default.a === 'function') _FldTextEditor_vue_vue_type_custom_index_0_blockType_fld_text_editor_name_description_v_model_form_data_description__WEBPACK_IMPORTED_MODULE_3___default()(component)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SS/FldTextEditor.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SS/FldTextEditor.vue?vue&type=custom&index=0&blockType=fld-text-editor&name=description&v-model=form_data.description":
/*!*******************************************************************************************************************************************************!*\
  !*** ./resources/js/components/SS/FldTextEditor.vue?vue&type=custom&index=0&blockType=fld-text-editor&name=description&v-model=form_data.description ***!
  \*******************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FldTextEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./FldTextEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SS/FldTextEditor.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FldTextEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./FldTextEditor.vue?vue&type=template&id=6e28bf98& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SS/FldTextEditor.vue?vue&type=template&id=6e28bf98&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FldTextEditor_vue_vue_type_template_id_6e28bf98___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);