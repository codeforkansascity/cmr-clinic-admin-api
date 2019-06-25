(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["client-grid"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientGrid.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ClientGrid.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SsGridColumnHeader__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SsGridColumnHeader */ "./resources/js/components/SsGridColumnHeader.vue");
/* harmony import */ var _SsGridPagination__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SsGridPagination */ "./resources/js/components/SsGridPagination.vue");
/* harmony import */ var _SsPaginationLocation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SsPaginationLocation */ "./resources/js/components/SsPaginationLocation.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: 'client-grid',
  components: {
    SsGridColumnHeader: _SsGridColumnHeader__WEBPACK_IMPORTED_MODULE_0__["default"],
    SsGridPaginationLocation: _SsPaginationLocation__WEBPACK_IMPORTED_MODULE_2__["default"],
    SsGridPagination: _SsGridPagination__WEBPACK_IMPORTED_MODULE_1__["default"]
  },
  props: {
    'params': {
      type: Object,
      default: function _default() {}
    }
  },
  mounted: function mounted() {
    this.params.Page = !isNaN(parseInt(this.params.Page)) ? parseInt(this.params.Page) : null;
    this.query = this.params.Search;
    this.current_page = this.params.Page;
    this.getData(1);
  },
  data: function data() {
    return {
      gridState: 'wait',
      query: this.params.Search,
      gridData: [],
      current_page: this.params.Page,
      last_page: null,
      total: null,
      sortOrder: this.params.sortOrder,
      sortKey: this.params.sortKey,
      global_error_message: null,
      form_errors: {
        page: false,
        keyword: false,
        column: false,
        direction: false
      },
      server_message: false,
      try_logging_in: false
    };
  },
  methods: {
    goToNew: function goToNew() {
      window.location.href = '/client/create';
    },
    sortColumn: function sortColumn(obj) {
      this.sortKey = obj.sortField;
      this.sortOrder = obj.sortOrder;
      this.getData(1);
    },
    getData: function getData(new_page_number) {
      var _this = this;

      this.global_error_message = null;
      var getPage;
      getPage = this.getDataUrl(new_page_number) + '&column=' + this.sortKey + '&direction=' + this.sortOrder;
      this.gridData = [];
      this.gridState = 'wait';

      if (getPage != null) {
        // We have a filter
        axios.get(getPage).then(function (responce) {
          if (responce.status === 200) {
            Object.keys(_this.form_errors).forEach(function (i) {
              return _this.form_errors[i] = false;
            });
            _this.gridData = responce.data.data;
            _this.total = responce.data.total;
            _this.current_page = responce.data.current_page;
            _this.last_page = responce.data.last_page || 1;
          } else {
            _this.server_message = res.status;
          }

          _this.gridState = 'good';
        }).catch(function (error) {
          if (error.response) {
            _this.gridState = 'error';

            if (error.response.status === 422) {
              // Clear errors out
              Object.keys(_this.form_errors).forEach(function (i) {
                return _this.form_errors[i] = false;
              }); // Set current errors

              Object.keys(error.response.data.errors).forEach(function (i) {
                return _this.form_errors[i] = error.response.data.errors[i];
              });
            } else if (error.response.status === 404) {
              // Record not found
              _this.server_message = 'Record not found';
              window.location = '/client';
            } else if (error.response.status === 419) {
              // Unknown status
              _this.server_message = 'Unknown Status, please try to ';
              _this.try_logging_in = true;
            } else if (error.response.status === 500) {
              // Unknown status
              _this.server_message = 'Server Error, please try to ';
              _this.try_logging_in = true;
            } else {
              _this.server_message = error.response.data.message;
            }
          } else {
            console.log(error.response);
            _this.server_message = error;
          }
        });
      }
    },
    getDataUrl: function getDataUrl(new_page_number) {
      var url = 'api-client?';
      var queryParams = [];
      queryParams.push('page=' + new_page_number);
      if (this.isDefined(this.query) && this.query.trim().length > 0) queryParams.push('keyword=' + this.query); //                if (this.isDefined(this.searchType)) queryParams.push('search_type=' + this.searchType);
      //                if (this.isDefined(this.showFilter)) queryParams.push('show_filter=' + this.showFilter);
      //                if (this.isDefined(this.contractorSelected)) queryParams.push('contractor_id=' + this.contractorSelected);

      if (queryParams.length > 0) url += queryParams.join('&');
      return url;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "grid-column-header",
  props: {
    'params': {
      default: function _default() {}
    },
    selectedKey: [String, Number, Boolean],
    title: [String, Number]
  },
  data: function data() {
    return {
      sortOrder: this.params.InitialSortOrder
    };
  },
  computed: {
    selected: function selected() {
      return this.params.sortField === this.selectedKey;
    }
  },
  methods: {
    sortBy: function sortBy() {
      if (this.sortOrder == 'asc') {
        this.sortOrder = -1;
      } else {
        this.sortOrder = this.sortOrder == 1 ? -1 : 1;
      }

      this.getData();
    },
    getData: function getData(new_page_number) {
      this.$emit("selectedSort", {
        sortField: this.params.sortField,
        sortOrder: this.sortOrder
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'ss-grid-pagination',
  props: {
    current_page: [String, Number],
    last_page: [String, Number],
    total: [String, Number]
  },
  data: function data() {
    return {
      pages: [],
      first_page_number: 1
    };
  },
  watch: {
    current_page: function current_page() {
      this.resetPageNumbers();
    },
    last_page: function last_page() {
      this.resetPageNumbers();
    },
    total: function total() {
      this.resetPageNumbers();
    }
  },
  computed: {
    next_page_number: function next_page_number() {
      return this.current_page < this.last_page ? this.current_page + 1 : null;
    },
    prev_page_number: function prev_page_number() {
      return this.current_page > 2 ? this.current_page - 1 : null;
    },
    isCurrentPageFirst: function isCurrentPageFirst() {
      return this.current_page == 1;
    },
    isCurrentPageLast: function isCurrentPageLast() {
      return this.current_page == this.last_page;
    }
  },
  methods: {
    resetPageNumbers: function resetPageNumbers() {
      this.pages = [];

      for (var i = 1; i <= this.last_page; i++) {
        this.pages.push(i);
      }
    },
    gotoPage: function gotoPage(page) {
      this.$emit('goto-page', page);
    },
    isCurrentPage: function isCurrentPage(page) {
      return page == this.current_page;
    },
    checkUrlNotNull: function checkUrlNotNull(url) {
      return url != null;
    },
    pageInRange: function pageInRange() {
      return this.go_to_page <= parseInt(this.last_page);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************/
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
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "pagination-location",
  props: {
    current_page: [String, Number],
    last_page: [String, Number],
    total: [String, Number]
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48& ***!
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
  return _c("div", [
    _vm.global_error_message
      ? _c(
          "div",
          { staticClass: "alert alert-danger", attrs: { role: "alert" } },
          [_vm._v("\n        " + _vm._s(_vm.global_error_message) + "\n    ")]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.server_message !== false
      ? _c(
          "div",
          { staticClass: "alert alert-danger", attrs: { role: "alert" } },
          [
            _vm._v("\n        " + _vm._s(this.server_message) + " "),
            _vm.try_logging_in
              ? _c("a", { attrs: { href: "/login" } }, [_vm._v("Login")])
              : _vm._e()
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _c("div", { staticClass: "grid-top row mb-0 align-items-center" }, [
      _c("div", { staticClass: "col-lg-8 mb-2" }, [
        _c(
          "form",
          { staticClass: "form-inline mb-0" },
          [
            _c(
              "a",
              {
                staticClass: "btn btn-primary mb-3 mb-sm-2 mr-3",
                attrs: { href: "#" },
                on: {
                  click: function($event) {
                    if (
                      !$event.type.indexOf("key") &&
                      _vm._k(
                        $event.keyCode,
                        "default",
                        undefined,
                        $event.key,
                        undefined
                      )
                    ) {
                      return null
                    }
                    return _vm.goToNew($event)
                  }
                }
              },
              [_vm._v("Add")]
            ),
            _vm._v(" "),
            _c(
              "search-form-group",
              {
                staticClass: "mb-0",
                attrs: { errors: _vm.form_errors.keyword, label: "Search" }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.query,
                      expression: "query"
                    }
                  ],
                  staticClass: "form-control mb-2",
                  attrs: {
                    name: "query",
                    id: "grid-filter-query-copy",
                    type: "text",
                    placeholder: "Name search",
                    "aria-label": "Name search"
                  },
                  domProps: { value: _vm.query },
                  on: {
                    keyup: function($event) {
                      return _vm.getData(1)
                    },
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.query = $event.target.value
                    }
                  }
                })
              ]
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "col-lg-4 text-lg-right mb-2" })
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "grid no-more-tables table-responsive mb-4" }, [
      _c("table", { staticClass: "table table-striped table-hover mb-0" }, [
        _c("thead", [
          _c(
            "tr",
            [
              _c(
                "ss-grid-column-header",
                {
                  attrs: {
                    selectedKey: _vm.sortKey,
                    title: "Sort by Full Name",
                    params: {
                      sortField: "full_name",
                      InitialSortOrder: "asc"
                    }
                  },
                  on: { selectedSort: _vm.sortColumn }
                },
                [_vm._v("\n                    Full Name                    ")]
              ),
              _vm._v(" "),
              _c(
                "ss-grid-column-header",
                {
                  attrs: {
                    selectedKey: _vm.sortKey,
                    title: "Sort by Phone",
                    params: {
                      sortField: "phone",
                      InitialSortOrder: "asc"
                    }
                  },
                  on: { selectedSort: _vm.sortColumn }
                },
                [_vm._v("\n                    Phone                    ")]
              ),
              _vm._v(" "),
              _c(
                "ss-grid-column-header",
                {
                  attrs: {
                    selectedKey: _vm.sortKey,
                    title: "Sort by Filing Court",
                    params: {
                      sortField: "filing_court",
                      InitialSortOrder: "asc"
                    }
                  },
                  on: { selectedSort: _vm.sortColumn }
                },
                [
                  _vm._v(
                    "\n                    Filing Court                    "
                  )
                ]
              ),
              _vm._v(" "),
              _c(
                "ss-grid-column-header",
                {
                  attrs: {
                    selectedKey: _vm.sortKey,
                    title: "Sort by Status",
                    params: {
                      sortField: "status",
                      InitialSortOrder: "asc"
                    }
                  },
                  on: { selectedSort: _vm.sortColumn }
                },
                [_vm._v("\n                    Status                    ")]
              ),
              _vm._v(" "),
              _c(
                "th",
                { staticClass: "text-center", staticStyle: { width: "20%" } },
                [_vm._v("Actions")]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "tbody",
          [
            _vm.gridState == "wait" ? _c("tr", [_vm._m(0)]) : _vm._e(),
            _vm._v(" "),
            _vm.gridState == "error" ? _c("tr", [_vm._m(1)]) : _vm._e(),
            _vm._v(" "),
            _vm.gridState == "good" && !_vm.gridData.length
              ? _c("tr", [_vm._m(2)])
              : _vm._l(this.gridData, function(row) {
                  return _c("tr", { key: row.id }, [
                    _c("td", { attrs: { "data-title": "Full Name" } }, [
                      _vm._v(_vm._s(row.full_name))
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { "data-title": "Phone" } }, [
                      _vm._v(_vm._s(row.phone))
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { "data-title": "Filing Court" } }, [
                      _vm._v(_vm._s(row.filing_court))
                    ]),
                    _vm._v(" "),
                    _c("td", { attrs: { "data-title": "Status" } }, [
                      _vm._v(_vm._s(row.status))
                    ]),
                    _vm._v(" "),
                    _c(
                      "td",
                      {
                        staticClass: "text-lg-center text-nowrap",
                        attrs: { "data-title": "Actions" }
                      },
                      [
                        _vm.params.CanEdit
                          ? _c(
                              "a",
                              {
                                staticClass: "grid-action-item",
                                attrs: { href: "/client/" + row.id + "/edit" }
                              },
                              [
                                _vm._v(
                                  "\n                        Edit\n                    "
                                )
                              ]
                            )
                          : _vm._e()
                      ]
                    )
                  ])
                })
          ],
          2
        )
      ])
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "grid-bottom row mb-0 align-items-center" },
      [
        _vm._m(3),
        _vm._v(" "),
        _c("ss-grid-pagination", {
          staticClass: "col-lg-4 mb-2",
          attrs: {
            current_page: _vm.current_page,
            last_page: _vm.last_page,
            total: _vm.total
          },
          on: {
            "goto-page": function($event) {
              return _vm.getData.apply(void 0, arguments)
            }
          }
        }),
        _vm._v(" "),
        _c("ss-grid-pagination-location", {
          staticClass: "col-lg-4 text-lg-right mb-2",
          attrs: {
            current_page: _vm.current_page,
            last_page: _vm.last_page,
            total: _vm.total
          }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      { staticStyle: { height: "475px" }, attrs: { colspan: "5" } },
      [
        _c(
          "div",
          {
            staticClass: "alert alert-info",
            staticStyle: {
              "font-size": "2em",
              "vertical-align": "middle",
              "text-align": "center",
              "margin-top": "160px"
            },
            attrs: { role: "alert" }
          },
          [_vm._v("Please wait.\n                    ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      { staticStyle: { height: "475px" }, attrs: { colspan: "5" } },
      [
        _c(
          "div",
          {
            staticClass: "alert alert-warning",
            staticStyle: {
              "font-size": "2em",
              "vertical-align": "middle",
              "text-align": "center",
              "margin-top": "160px"
            },
            attrs: { role: "alert" }
          },
          [_vm._v("Error please try again.\n                    ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "td",
      { staticStyle: { height: "475px" }, attrs: { colspan: "5" } },
      [
        _c(
          "div",
          {
            staticClass: "alert alert-warning",
            staticStyle: {
              "font-size": "2em",
              "vertical-align": "middle",
              "text-align": "center",
              "margin-top": "160px"
            },
            attrs: { role: "alert" }
          },
          [_vm._v("No matching records found.\n                    ")]
        )
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col-lg-4 mb-2" }, [
      _c(
        "a",
        {
          staticClass: "btn btn-primary mb-2 mr-2",
          attrs: { href: "/client/download" }
        },
        [_vm._v("Export to Excel")]
      ),
      _vm._v(" "),
      _c(
        "a",
        { staticClass: "btn btn-primary mb-2 mr-2", attrs: { href: "#TODO" } },
        [_vm._v("Print PDF")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
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
  return _c("th", [
    _c(
      "a",
      {
        class: { active: _vm.selected },
        attrs: { href: "#", title: "title" },
        on: {
          click: function($event) {
            $event.preventDefault()
            return _vm.sortBy()
          }
        }
      },
      [
        _vm._t("default"),
        _vm._v(" "),
        _c("span", {
          staticClass: "arrow",
          class: _vm.sortOrder > 0 ? "asc" : "dsc"
        })
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a& ***!
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
  return _c("div", [
    _c(
      "div",
      {
        staticClass:
          "btn-group pagination justify-content-start justify-content-lg-center",
        attrs: { role: "group", "aria-label": "Pagination button group" }
      },
      [
        _c(
          "a",
          {
            staticClass: "btn btn-outline-secondary mb-2",
            class: { disabled: _vm.isCurrentPageFirst },
            attrs: { href: "#", title: "First" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.gotoPage(_vm.first_page_number)
              }
            }
          },
          [_vm._v("\n            first\n        ")]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "btn btn-outline-secondary mb-2",
            class: { disabled: _vm.isCurrentPageFirst },
            attrs: { href: "#", title: "Previous" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.gotoPage(_vm.prev_page_number)
              }
            }
          },
          [_vm._v("\n            prev\n        ")]
        ),
        _vm._v(" "),
        _vm._l(_vm.pages, function(page) {
          return page > _vm.current_page - 2 && page < _vm.current_page + 2
            ? [
                _c(
                  "a",
                  {
                    class: {
                      "btn mb-2": true,
                      "btn-secondary active": _vm.isCurrentPage(page),
                      "btn-outline-secondary": !_vm.isCurrentPage(page)
                    },
                    attrs: { href: "#", title: "Page " + page },
                    on: {
                      click: function($event) {
                        $event.preventDefault()
                        return _vm.gotoPage(page)
                      }
                    }
                  },
                  [
                    _vm._v(
                      "\n                " + _vm._s(page) + "\n            "
                    )
                  ]
                )
              ]
            : _vm._e()
        }),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "btn btn-outline-secondary mb-2",
            class: { disabled: _vm.isCurrentPageLast },
            attrs: { href: "#", title: "Next" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.gotoPage(_vm.next_page_number)
              }
            }
          },
          [_vm._v("\n            next\n        ")]
        ),
        _vm._v(" "),
        _c(
          "a",
          {
            staticClass: "btn btn-outline-secondary mb-2",
            class: { disabled: _vm.isCurrentPageLast },
            attrs: { href: "#", title: "Last" },
            on: {
              click: function($event) {
                $event.preventDefault()
                return _vm.gotoPage(_vm.last_page)
              }
            }
          },
          [_vm._v("\n            last\n        ")]
        )
      ],
      2
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c&":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c& ***!
  \***********************************************************************************************************************************************************************************************************************/
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
  return _c("div", [
    _c("div", { staticClass: "mb-2" }, [
      _vm._v(
        "\n        Page " +
          _vm._s(_vm.current_page) +
          " of " +
          _vm._s(_vm.last_page) +
          ", " +
          _vm._s(_vm.total) +
          " Total Results\n    "
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/ClientGrid.vue":
/*!************************************************!*\
  !*** ./resources/js/components/ClientGrid.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ClientGrid.vue?vue&type=template&id=b1b4fc48& */ "./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48&");
/* harmony import */ var _ClientGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ClientGrid.vue?vue&type=script&lang=js& */ "./resources/js/components/ClientGrid.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ClientGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ClientGrid.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/ClientGrid.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ClientGrid.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./ClientGrid.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientGrid.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./ClientGrid.vue?vue&type=template&id=b1b4fc48& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/ClientGrid.vue?vue&type=template&id=b1b4fc48&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientGrid_vue_vue_type_template_id_b1b4fc48___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SsGridColumnHeader.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/SsGridColumnHeader.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true& */ "./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true&");
/* harmony import */ var _SsGridColumnHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SsGridColumnHeader.vue?vue&type=script&lang=js& */ "./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SsGridColumnHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "14338f94",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SsGridColumnHeader.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridColumnHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SsGridColumnHeader.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridColumnHeader.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridColumnHeader_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridColumnHeader.vue?vue&type=template&id=14338f94&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridColumnHeader_vue_vue_type_template_id_14338f94_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SsGridPagination.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/SsGridPagination.vue ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SsGridPagination.vue?vue&type=template&id=e476f72a& */ "./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a&");
/* harmony import */ var _SsGridPagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SsGridPagination.vue?vue&type=script&lang=js& */ "./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SsGridPagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SsGridPagination.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridPagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SsGridPagination.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridPagination.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridPagination_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a& ***!
  \*************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./SsGridPagination.vue?vue&type=template&id=e476f72a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsGridPagination.vue?vue&type=template&id=e476f72a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsGridPagination_vue_vue_type_template_id_e476f72a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/SsPaginationLocation.vue":
/*!**********************************************************!*\
  !*** ./resources/js/components/SsPaginationLocation.vue ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SsPaginationLocation.vue?vue&type=template&id=2f5e554c& */ "./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c&");
/* harmony import */ var _SsPaginationLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SsPaginationLocation.vue?vue&type=script&lang=js& */ "./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SsPaginationLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/SsPaginationLocation.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsPaginationLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./SsPaginationLocation.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsPaginationLocation.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SsPaginationLocation_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c& ***!
  \*****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./SsPaginationLocation.vue?vue&type=template&id=2f5e554c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/SsPaginationLocation.vue?vue&type=template&id=2f5e554c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SsPaginationLocation_vue_vue_type_template_id_2f5e554c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);