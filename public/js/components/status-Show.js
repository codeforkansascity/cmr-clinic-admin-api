(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["status-Show"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusShow.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/StatusShow.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "status-show",
  props: {
    record: {
      type: [Boolean, Object],
      "default": false
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c& ***!
  \*************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-md-6" }, [
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Name\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.name,
                callback: function($$v) {
                  _vm.$set(_vm.record, "name", $$v)
                },
                expression: "record.name"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Alias\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.alias,
                callback: function($$v) {
                  _vm.$set(_vm.record, "alias", $$v)
                },
                expression: "record.alias"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Sequence\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.sequence,
                callback: function($$v) {
                  _vm.$set(_vm.record, "sequence", $$v)
                },
                expression: "record.sequence"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Deleted At\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.deleted_at,
                callback: function($$v) {
                  _vm.$set(_vm.record, "deleted_at", $$v)
                },
                expression: "record.deleted_at"
              }
            })
          ],
          1
        )
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "col-md-6" }, [_vm._v("\n        test\n    ")])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/StatusShow.vue":
/*!************************************************!*\
  !*** ./resources/js/components/StatusShow.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StatusShow.vue?vue&type=template&id=b0ec398c& */ "./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c&");
/* harmony import */ var _StatusShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StatusShow.vue?vue&type=script&lang=js& */ "./resources/js/components/StatusShow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _StatusShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/StatusShow.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/StatusShow.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/StatusShow.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./StatusShow.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusShow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./StatusShow.vue?vue&type=template&id=b0ec398c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusShow.vue?vue&type=template&id=b0ec398c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusShow_vue_vue_type_template_id_b0ec398c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);