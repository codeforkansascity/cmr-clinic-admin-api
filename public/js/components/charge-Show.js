(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["charge-Show"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChargeShow.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ChargeShow.vue?vue&type=script&lang=js& ***!
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
  name: "charge-show",
  props: {
    record: {
      type: [Boolean, Object],
      "default": false
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808& ***!
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
          _vm._v("\n                Conviction Id\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.conviction_id,
                callback: function($$v) {
                  _vm.$set(_vm.record, "conviction_id", $$v)
                },
                expression: "record.conviction_id"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Charge\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.charge,
                callback: function($$v) {
                  _vm.$set(_vm.record, "charge", $$v)
                },
                expression: "record.charge"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Citation\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.citation,
                callback: function($$v) {
                  _vm.$set(_vm.record, "citation", $$v)
                },
                expression: "record.citation"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Conviction Class Type\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.conviction_class_type,
                callback: function($$v) {
                  _vm.$set(_vm.record, "conviction_class_type", $$v)
                },
                expression: "record.conviction_class_type"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Conviction Charge Type\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.conviction_charge_type,
                callback: function($$v) {
                  _vm.$set(_vm.record, "conviction_charge_type", $$v)
                },
                expression: "record.conviction_charge_type"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Sentence\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.sentence,
                callback: function($$v) {
                  _vm.$set(_vm.record, "sentence", $$v)
                },
                expression: "record.sentence"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Convicted Text\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.convicted_text,
                callback: function($$v) {
                  _vm.$set(_vm.record, "convicted_text", $$v)
                },
                expression: "record.convicted_text"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Eligible Text\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.eligible_text,
                callback: function($$v) {
                  _vm.$set(_vm.record, "eligible_text", $$v)
                },
                expression: "record.eligible_text"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Please Expunge Text\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.please_expunge_text,
                callback: function($$v) {
                  _vm.$set(_vm.record, "please_expunge_text", $$v)
                },
                expression: "record.please_expunge_text"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                To Print\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.to_print,
                callback: function($$v) {
                  _vm.$set(_vm.record, "to_print", $$v)
                },
                expression: "record.to_print"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Notes\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.notes,
                callback: function($$v) {
                  _vm.$set(_vm.record, "notes", $$v)
                },
                expression: "record.notes"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Convicted\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.convicted,
                callback: function($$v) {
                  _vm.$set(_vm.record, "convicted", $$v)
                },
                expression: "record.convicted"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Eligible\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.eligible,
                callback: function($$v) {
                  _vm.$set(_vm.record, "eligible", $$v)
                },
                expression: "record.eligible"
              }
            })
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group row mb-2 mb-md-0 text-only" }, [
        _c("label", { staticClass: "col-md-4 col-form-label text-md-right" }, [
          _vm._v("\n                Please Expunge\n            ")
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "col-md-8" },
          [
            _c("dsp-text", {
              model: {
                value: _vm.record.please_expunge,
                callback: function($$v) {
                  _vm.$set(_vm.record, "please_expunge", $$v)
                },
                expression: "record.please_expunge"
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

/***/ "./resources/js/components/ChargeShow.vue":
/*!************************************************!*\
  !*** ./resources/js/components/ChargeShow.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ChargeShow.vue?vue&type=template&id=8c055808& */ "./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808&");
/* harmony import */ var _ChargeShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ChargeShow.vue?vue&type=script&lang=js& */ "./resources/js/components/ChargeShow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ChargeShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ChargeShow.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ChargeShow.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ChargeShow.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChargeShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ChargeShow.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChargeShow.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ChargeShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./ChargeShow.vue?vue&type=template&id=8c055808& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ChargeShow.vue?vue&type=template&id=8c055808&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ChargeShow_vue_vue_type_template_id_8c055808___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);