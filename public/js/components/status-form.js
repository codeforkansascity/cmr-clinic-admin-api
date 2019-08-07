(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["status-form"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusForm.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/StatusForm.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

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
  name: "status-form",
  props: {
    record: {
      type: [Boolean, Object],
      "default": false
    },
    csrf_token: {
      type: String,
      "default": ""
    }
  },
  data: function data() {
    return {
      form_data: {
        // _method: 'patch',
        _token: this.csrf_token,
        id: 0,
        name: "",
        alias: "",
        sequence: 0,
        deleted_at: ""
      },
      form_errors: {
        id: false,
        name: false,
        alias: false,
        sequence: false,
        deleted_at: false
      },
      server_message: false,
      try_logging_in: false,
      processing: false
    };
  },
  mounted: function mounted() {
    var _this = this;

    if (this.record !== false) {
      // this.form_data._method = 'patch';
      Object.keys(this.record).forEach(function (i) {
        return _this.form_data[i] = _this.record[i];
      });
    } else {// this.form_data._method = 'post';
    }
  },
  methods: {
    handleSubmit: function () {
      var _handleSubmit = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _this2 = this;

        var url, amethod;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                this.server_message = false;
                this.processing = true;
                url = "";
                amethod = "";

                if (this.form_data.id) {
                  url = "/status/" + this.form_data.id;
                  amethod = "put";
                } else {
                  url = "/status";
                  amethod = "post";
                }

                _context.next = 7;
                return axios__WEBPACK_IMPORTED_MODULE_1___default()({
                  method: amethod,
                  url: url,
                  data: this.form_data
                }).then(function (res) {
                  if (res.status === 200) {
                    window.location = "/status";
                  } else {
                    _this2.server_message = res.status;
                  }
                })["catch"](function (error) {
                  if (error.response) {
                    if (error.response.status === 422) {
                      // Clear errors out
                      Object.keys(_this2.form_errors).forEach(function (i) {
                        return _this2.form_errors[i] = false;
                      }); // Set current errors

                      Object.keys(error.response.data.errors).forEach(function (i) {
                        return _this2.form_errors[i] = error.response.data.errors[i];
                      });
                    } else if (error.response.status === 404) {
                      // Record not found
                      _this2.server_message = "Record not found";
                      window.location = "/status";
                    } else if (error.response.status === 419) {
                      // Unknown status
                      _this2.server_message = "Unknown Status, please try to ";
                      _this2.try_logging_in = true;
                    } else if (error.response.status === 500) {
                      // Unknown status
                      _this2.server_message = "Server Error, please try to ";
                      _this2.try_logging_in = true;
                    } else {
                      _this2.server_message = error.response.data.message;
                    }
                  } else {
                    console.log(error.response);
                    _this2.server_message = error;
                  }

                  _this2.processing = false;
                });

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function handleSubmit() {
        return _handleSubmit.apply(this, arguments);
      }

      return handleSubmit;
    }()
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe& ***!
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
  return _c(
    "form",
    {
      staticClass: "form-horizontal",
      on: {
        submit: function($event) {
          $event.preventDefault()
          return _vm.handleSubmit($event)
        }
      }
    },
    [
      _vm.server_message !== false
        ? _c(
            "div",
            { staticClass: "alert alert-danger", attrs: { role: "alert" } },
            [
              _vm._v("\n        " + _vm._s(this.server_message) + "\n        "),
              _vm.try_logging_in
                ? _c("a", { attrs: { href: "/login" } }, [_vm._v("Login")])
                : _vm._e()
            ]
          )
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Id",
                  "label-for": "id",
                  errors: _vm.form_errors.id
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "id" },
                  model: {
                    value: _vm.form_data.id,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "id", $$v)
                    },
                    expression: "form_data.id"
                  }
                })
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Name",
                  "label-for": "name",
                  errors: _vm.form_errors.name,
                  required: true
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "name", required: "" },
                  model: {
                    value: _vm.form_data.name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "name", $$v)
                    },
                    expression: "form_data.name"
                  }
                }),
                _vm._v(" "),
                _c("template", { slot: "help" }, [
                  _vm._v(
                    "\n                    Name must be unique.\n                "
                  )
                ])
              ],
              2
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Alias",
                  "label-for": "alias",
                  errors: _vm.form_errors.alias
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "alias" },
                  model: {
                    value: _vm.form_data.alias,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "alias", $$v)
                    },
                    expression: "form_data.alias"
                  }
                })
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Sequence",
                  "label-for": "sequence",
                  errors: _vm.form_errors.sequence
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "sequence" },
                  model: {
                    value: _vm.form_data.sequence,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "sequence", $$v)
                    },
                    expression: "form_data.sequence"
                  }
                })
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Deleted At",
                  "label-for": "deleted_at",
                  errors: _vm.form_errors.deleted_at
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "deleted_at" },
                  model: {
                    value: _vm.form_data.deleted_at,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "deleted_at", $$v)
                    },
                    expression: "form_data.deleted_at"
                  }
                })
              ],
              1
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "form-group mt-4" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-6" }, [
            _c(
              "button",
              {
                staticClass: "btn btn-primary",
                attrs: { type: "submit", disabled: _vm.processing }
              },
              [
                this.form_data.id
                  ? _c("span", [_vm._v("Change")])
                  : _c("span", [_vm._v("Add")])
              ]
            )
          ]),
          _vm._v(" "),
          _vm._m(0)
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-md-6 text-md-right mt-2 mt-md-0" }, [
      _c("a", { staticClass: "btn btn-default", attrs: { href: "/status" } }, [
        _vm._v("Cancel")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/StatusForm.vue":
/*!************************************************!*\
  !*** ./resources/js/components/StatusForm.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./StatusForm.vue?vue&type=template&id=50104cfe& */ "./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe&");
/* harmony import */ var _StatusForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./StatusForm.vue?vue&type=script&lang=js& */ "./resources/js/components/StatusForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _StatusForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__["render"],
  _StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/StatusForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/StatusForm.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/StatusForm.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./StatusForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./StatusForm.vue?vue&type=template&id=50104cfe& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/StatusForm.vue?vue&type=template&id=50104cfe&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_StatusForm_vue_vue_type_template_id_50104cfe___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);