(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["client-form"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientForm.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ClientForm.vue?vue&type=script&lang=js& ***!
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "client-form",
  props: {
    record: {
      type: [Boolean, Object],
      default: false
    },
    csrf_token: {
      type: String,
      default: ""
    }
  },
  data: function data() {
    return {
      form_data: {
        // _method: 'patch',
        _token: this.csrf_token,
        id: 0,
        name: "",
        phone: "",
        email: "",
        sex: "",
        race: "",
        dob_text: "",
        address_line_1: "",
        address_line_2: "",
        city: "",
        state: "",
        zip_code: "",
        license_number: "",
        license_issuing_state: "",
        license_expiration_date_text: "",
        filing_court: "",
        judicial_circuit_number: "",
        count_name: "",
        judge_name: "",
        division_name: "",
        petitioner_name: "",
        division_number: "",
        city_name_here: "",
        county_name: "",
        arresting_county: "",
        prosecuting_county: "",
        arresting_municipality: "",
        other_agencies_name: "",
        previous_expungements: "",
        notes: "",
        external_ref: "",
        any_pending_cases: "",
        deleted_at: "",
        status_id: 0,
        dob: null,
        license_expiration_date: null,
        cms_client_number: "",
        cms_matter_number: "",
        assignment_id: 0,
        step_id: 0
      },
      form_errors: {
        id: false,
        name: false,
        phone: false,
        email: false,
        sex: false,
        race: false,
        dob_text: false,
        address_line_1: false,
        address_line_2: false,
        city: false,
        state: false,
        zip_code: false,
        license_number: false,
        license_issuing_state: false,
        license_expiration_date_text: false,
        filing_court: false,
        judicial_circuit_number: false,
        count_name: false,
        judge_name: false,
        division_name: false,
        petitioner_name: false,
        division_number: false,
        city_name_here: false,
        county_name: false,
        arresting_county: false,
        prosecuting_county: false,
        arresting_municipality: false,
        other_agencies_name: false,
        previous_expungements: false,
        notes: false,
        external_ref: false,
        any_pending_cases: false,
        deleted_at: false,
        status_id: false,
        dob: false,
        license_expiration_date: false,
        cms_client_number: false,
        cms_matter_number: false,
        assignment_id: false,
        step_id: false
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
                  url = "/client/" + this.form_data.id;
                  amethod = "put";
                } else {
                  url = "/client";
                  amethod = "post";
                }

                _context.next = 7;
                return axios__WEBPACK_IMPORTED_MODULE_1___default()({
                  method: amethod,
                  url: url,
                  data: this.form_data
                }).then(function (res) {
                  if (res.status === 200) {
                    window.location = "/client";
                  } else {
                    _this2.server_message = res.status;
                  }
                }).catch(function (error) {
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
                      window.location = "/client";
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c& ***!
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
                  label: "Phone",
                  "label-for": "phone",
                  errors: _vm.form_errors.phone
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "phone" },
                  model: {
                    value: _vm.form_data.phone,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "phone", $$v)
                    },
                    expression: "form_data.phone"
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
                  label: "Email",
                  "label-for": "email",
                  errors: _vm.form_errors.email
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "email" },
                  model: {
                    value: _vm.form_data.email,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "email", $$v)
                    },
                    expression: "form_data.email"
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
                  label: "Sex",
                  "label-for": "sex",
                  errors: _vm.form_errors.sex
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "sex" },
                  model: {
                    value: _vm.form_data.sex,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "sex", $$v)
                    },
                    expression: "form_data.sex"
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
                  label: "Race",
                  "label-for": "race",
                  errors: _vm.form_errors.race
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "race" },
                  model: {
                    value: _vm.form_data.race,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "race", $$v)
                    },
                    expression: "form_data.race"
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
                  label: "Dob Text",
                  "label-for": "dob_text",
                  errors: _vm.form_errors.dob_text
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "dob_text" },
                  model: {
                    value: _vm.form_data.dob_text,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "dob_text", $$v)
                    },
                    expression: "form_data.dob_text"
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
                  label: "Address Line 1",
                  "label-for": "address_line_1",
                  errors: _vm.form_errors.address_line_1
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "address_line_1" },
                  model: {
                    value: _vm.form_data.address_line_1,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "address_line_1", $$v)
                    },
                    expression: "form_data.address_line_1"
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
                  label: "Address Line 2",
                  "label-for": "address_line_2",
                  errors: _vm.form_errors.address_line_2
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "address_line_2" },
                  model: {
                    value: _vm.form_data.address_line_2,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "address_line_2", $$v)
                    },
                    expression: "form_data.address_line_2"
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
                  label: "City",
                  "label-for": "city",
                  errors: _vm.form_errors.city
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "city" },
                  model: {
                    value: _vm.form_data.city,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "city", $$v)
                    },
                    expression: "form_data.city"
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
                  label: "State",
                  "label-for": "state",
                  errors: _vm.form_errors.state
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "state" },
                  model: {
                    value: _vm.form_data.state,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "state", $$v)
                    },
                    expression: "form_data.state"
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
                  label: "Zip Code",
                  "label-for": "zip_code",
                  errors: _vm.form_errors.zip_code
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "zip_code" },
                  model: {
                    value: _vm.form_data.zip_code,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "zip_code", $$v)
                    },
                    expression: "form_data.zip_code"
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
                  label: "License Number",
                  "label-for": "license_number",
                  errors: _vm.form_errors.license_number
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "license_number" },
                  model: {
                    value: _vm.form_data.license_number,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "license_number", $$v)
                    },
                    expression: "form_data.license_number"
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
                  label: "License Issuing State",
                  "label-for": "license_issuing_state",
                  errors: _vm.form_errors.license_issuing_state
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "license_issuing_state" },
                  model: {
                    value: _vm.form_data.license_issuing_state,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "license_issuing_state", $$v)
                    },
                    expression: "form_data.license_issuing_state"
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
                  label: "License Expiration Date Text",
                  "label-for": "license_expiration_date_text",
                  errors: _vm.form_errors.license_expiration_date_text
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "license_expiration_date_text" },
                  model: {
                    value: _vm.form_data.license_expiration_date_text,
                    callback: function($$v) {
                      _vm.$set(
                        _vm.form_data,
                        "license_expiration_date_text",
                        $$v
                      )
                    },
                    expression: "form_data.license_expiration_date_text"
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
                  label: "Filing Court",
                  "label-for": "filing_court",
                  errors: _vm.form_errors.filing_court
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "filing_court" },
                  model: {
                    value: _vm.form_data.filing_court,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "filing_court", $$v)
                    },
                    expression: "form_data.filing_court"
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
                  label: "Judicial Circuit Number",
                  "label-for": "judicial_circuit_number",
                  errors: _vm.form_errors.judicial_circuit_number
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "judicial_circuit_number" },
                  model: {
                    value: _vm.form_data.judicial_circuit_number,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "judicial_circuit_number", $$v)
                    },
                    expression: "form_data.judicial_circuit_number"
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
                  label: "Count Name",
                  "label-for": "count_name",
                  errors: _vm.form_errors.count_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "count_name" },
                  model: {
                    value: _vm.form_data.count_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "count_name", $$v)
                    },
                    expression: "form_data.count_name"
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
                  label: "Judge Name",
                  "label-for": "judge_name",
                  errors: _vm.form_errors.judge_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "judge_name" },
                  model: {
                    value: _vm.form_data.judge_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "judge_name", $$v)
                    },
                    expression: "form_data.judge_name"
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
                  label: "Division Name",
                  "label-for": "division_name",
                  errors: _vm.form_errors.division_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "division_name" },
                  model: {
                    value: _vm.form_data.division_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "division_name", $$v)
                    },
                    expression: "form_data.division_name"
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
                  label: "Petitioner Name",
                  "label-for": "petitioner_name",
                  errors: _vm.form_errors.petitioner_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "petitioner_name" },
                  model: {
                    value: _vm.form_data.petitioner_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "petitioner_name", $$v)
                    },
                    expression: "form_data.petitioner_name"
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
                  label: "Division Number",
                  "label-for": "division_number",
                  errors: _vm.form_errors.division_number
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "division_number" },
                  model: {
                    value: _vm.form_data.division_number,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "division_number", $$v)
                    },
                    expression: "form_data.division_number"
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
                  label: "City Name Here",
                  "label-for": "city_name_here",
                  errors: _vm.form_errors.city_name_here
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "city_name_here" },
                  model: {
                    value: _vm.form_data.city_name_here,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "city_name_here", $$v)
                    },
                    expression: "form_data.city_name_here"
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
                  label: "County Name",
                  "label-for": "county_name",
                  errors: _vm.form_errors.county_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "county_name" },
                  model: {
                    value: _vm.form_data.county_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "county_name", $$v)
                    },
                    expression: "form_data.county_name"
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
                  label: "Arresting County",
                  "label-for": "arresting_county",
                  errors: _vm.form_errors.arresting_county
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "arresting_county" },
                  model: {
                    value: _vm.form_data.arresting_county,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "arresting_county", $$v)
                    },
                    expression: "form_data.arresting_county"
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
                  label: "Prosecuting County",
                  "label-for": "prosecuting_county",
                  errors: _vm.form_errors.prosecuting_county
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "prosecuting_county" },
                  model: {
                    value: _vm.form_data.prosecuting_county,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "prosecuting_county", $$v)
                    },
                    expression: "form_data.prosecuting_county"
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
                  label: "Arresting Municipality",
                  "label-for": "arresting_municipality",
                  errors: _vm.form_errors.arresting_municipality
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "arresting_municipality" },
                  model: {
                    value: _vm.form_data.arresting_municipality,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "arresting_municipality", $$v)
                    },
                    expression: "form_data.arresting_municipality"
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
                  label: "Other Agencies Name",
                  "label-for": "other_agencies_name",
                  errors: _vm.form_errors.other_agencies_name
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "other_agencies_name" },
                  model: {
                    value: _vm.form_data.other_agencies_name,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "other_agencies_name", $$v)
                    },
                    expression: "form_data.other_agencies_name"
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
                  label: "Previous Expungements",
                  "label-for": "previous_expungements",
                  errors: _vm.form_errors.previous_expungements
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "previous_expungements" },
                  model: {
                    value: _vm.form_data.previous_expungements,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "previous_expungements", $$v)
                    },
                    expression: "form_data.previous_expungements"
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
                  label: "Notes",
                  "label-for": "notes",
                  errors: _vm.form_errors.notes
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "notes" },
                  model: {
                    value: _vm.form_data.notes,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "notes", $$v)
                    },
                    expression: "form_data.notes"
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
                  label: "External Ref",
                  "label-for": "external_ref",
                  errors: _vm.form_errors.external_ref
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "external_ref" },
                  model: {
                    value: _vm.form_data.external_ref,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "external_ref", $$v)
                    },
                    expression: "form_data.external_ref"
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
                  label: "Any Pending Cases",
                  "label-for": "any_pending_cases",
                  errors: _vm.form_errors.any_pending_cases
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "any_pending_cases" },
                  model: {
                    value: _vm.form_data.any_pending_cases,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "any_pending_cases", $$v)
                    },
                    expression: "form_data.any_pending_cases"
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
      _c("div", { staticClass: "row" }, [
        _c(
          "div",
          { staticClass: "col-md-12" },
          [
            _c(
              "std-form-group",
              {
                attrs: {
                  label: "Status Id",
                  "label-for": "status_id",
                  errors: _vm.form_errors.status_id
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "status_id" },
                  model: {
                    value: _vm.form_data.status_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "status_id", $$v)
                    },
                    expression: "form_data.status_id"
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
                  label: "Dob",
                  "label-for": "dob",
                  errors: _vm.form_errors.dob
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "dob" },
                  model: {
                    value: _vm.form_data.dob,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "dob", $$v)
                    },
                    expression: "form_data.dob"
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
                  label: "License Expiration Date",
                  "label-for": "license_expiration_date",
                  errors: _vm.form_errors.license_expiration_date
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "license_expiration_date" },
                  model: {
                    value: _vm.form_data.license_expiration_date,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "license_expiration_date", $$v)
                    },
                    expression: "form_data.license_expiration_date"
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
                  label: "Cms Client Number",
                  "label-for": "cms_client_number",
                  errors: _vm.form_errors.cms_client_number
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "cms_client_number" },
                  model: {
                    value: _vm.form_data.cms_client_number,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "cms_client_number", $$v)
                    },
                    expression: "form_data.cms_client_number"
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
                  label: "Cms Matter Number",
                  "label-for": "cms_matter_number",
                  errors: _vm.form_errors.cms_matter_number
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "cms_matter_number" },
                  model: {
                    value: _vm.form_data.cms_matter_number,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "cms_matter_number", $$v)
                    },
                    expression: "form_data.cms_matter_number"
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
                  label: "Assignment Id",
                  "label-for": "assignment_id",
                  errors: _vm.form_errors.assignment_id
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "assignment_id" },
                  model: {
                    value: _vm.form_data.assignment_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "assignment_id", $$v)
                    },
                    expression: "form_data.assignment_id"
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
                  label: "Step Id",
                  "label-for": "step_id",
                  errors: _vm.form_errors.step_id
                }
              },
              [
                _c("fld-input", {
                  attrs: { name: "step_id" },
                  model: {
                    value: _vm.form_data.step_id,
                    callback: function($$v) {
                      _vm.$set(_vm.form_data, "step_id", $$v)
                    },
                    expression: "form_data.step_id"
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
      _c("a", { staticClass: "btn btn-default", attrs: { href: "/client" } }, [
        _vm._v("Cancel")
      ])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/ClientForm.vue":
/*!************************************************!*\
  !*** ./resources/js/components/ClientForm.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ClientForm.vue?vue&type=template&id=9f27d74c& */ "./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c&");
/* harmony import */ var _ClientForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ClientForm.vue?vue&type=script&lang=js& */ "./resources/js/components/ClientForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ClientForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ClientForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ClientForm.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ClientForm.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ClientForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./ClientForm.vue?vue&type=template&id=9f27d74c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientForm.vue?vue&type=template&id=9f27d74c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientForm_vue_vue_type_template_id_9f27d74c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);