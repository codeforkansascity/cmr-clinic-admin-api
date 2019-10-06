<template>
    <div>
        <div
            v-if="global_error_message"
            class="alert alert-danger"
            role="alert"
        >
            {{ global_error_message }}
        </div>
        <!-- Grid Actions Top -->
        <div class="grid-top row mb-0 align-items-center">
            <div class="col-lg-8 mb-2">
                <form class="form-inline mb-0">
                    <a
                        v-if="params.CanAdd"
                        href="#"
                        @click.default="goToNew"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                        >Add Role</a
                    >
                    <div class="input-group mb-0 mr-2">
                        <label
                            for="grid-filter-dropdown"
                            class="mb-2 mr-2 pt-2 pt-sm-0"
                        >
                            Search by
                        </label>
                        <select
                            id="grid-filter-dropdown"
                            class="form-control mb-2"
                        >
                            <option value="name">Name</option>
                        </select>
                    </div>
                    <div class="input-group mb-0">
                        <label
                            for="grid-filter-query-copy"
                            class="mb-2 mr-2 pt-2 pt-sm-0"
                        >
                            Search
                        </label>
                        <input
                            name="query"
                            id="grid-filter-query-copy"
                            v-model="query"
                            @keyup="getData(1)"
                            class="form-control mb-2"
                            type="text"
                            placeholder="Name search"
                            aria-label="Name search"
                        />
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-lg-right mb-2"></div>
        </div>
        <!-- end Grid Actions Top -->

        <!-- Grid -->
        <div class="grid no-more-tables table-responsive mb-4">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <ss-grid-column-header
                            v-on:selectedSort="sortColumn"
                            v-bind:selectedKey="sortKey"
                            title="Sort by Name"
                            :params="{
                                sortField: 'name',
                                InitialSortOrder: 'asc'
                            }"
                        >
                            Name
                        </ss-grid-column-header>
                        <ss-grid-column-header
                            v-on:selectedSort="sortColumn"
                            v-bind:selectedKey="sortKey"
                            title="Sort by Alias"
                            :params="{
                                sortField: 'alias',
                                InitialSortOrder: 'asc'
                            }"
                        >
                            Alias
                        </ss-grid-column-header>
                        <ss-grid-column-header
                            v-on:selectedSort="sortColumn"
                            v-bind:selectedKey="sortKey"
                            title="Sort by On Master Roster"
                            :params="{
                                sortField: 'on_master_roster',
                                InitialSortOrder: 'asc'
                            }"
                        >
                            On Master Roster
                        </ss-grid-column-header>
                        <th style="width:20%;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="gridState == 'wait'">
                        <td colspan="4" style=" height: 475px;">
                            <div
                                class="alert alert-info"
                                style="font-size: 2em;   vertical-align: middle;   text-align: center; margin-top: 160px;"
                                role="alert"
                            >
                                Please wait.
                            </div>
                        </td>
                    </tr>
                    <tr v-if="gridState == 'error'">
                        <td colspan="4" style=" height: 475px;">
                            <div
                                class="alert alert-warning"
                                style="font-size: 2em;   vertical-align: middle;   text-align: center; margin-top: 160px;"
                                role="alert"
                            >
                                No matching records were found.
                            </div>
                        </td>
                    </tr>
                    <tr v-if="gridState != 'wait' && !gridData.length">
                        <td colspan="4" style=" height: 475px;">
                            <div
                                class="alert alert-danger"
                                style="font-size: 2em;   vertical-align: middle;   text-align: center; margin-top: 160px;"
                                role="alert"
                            >
                                Error please try again.
                            </div>
                        </td>
                    </tr>

                    <tr v-else v-for="row in this.gridData" :key="row.id">
                        <td data-title="Name">
                            <a
                                v-bind:href="'/role/' + row.id"
                                v-if="params.CanShow == '1'"
                            >
                                {{ row.name }}
                            </a>
                            <span v-if="params.CanShow != '1'">
                                {{ row.name }}
                            </span>
                        </td>
                        <td data-title="Alias">{{ row.alias }}</td>
                        <td data-title="On Master Roster">
                            {{ row.on_master_roster }}
                        </td>
                        <td
                            data-title="Actions"
                            class="text-lg-center text-nowrap"
                        >
                            <a
                                v-bind:href="'/role/' + row.id + '/edit'"
                                v-if="params.CanEdit == '1'"
                                class="grid-action-item"
                            >
                                Edit
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- end Grid -->

        <!-- Grid Actions Bottom -->
        <div class="grid-bottom row mb-0 align-items-center">
            <div class="col-lg-4 mb-2">
                <a href="/role/download" class="btn btn-primary mb-2 mr-2"
                    >Export to Excel</a
                >
                <a href="#TODO" class="btn btn-primary mb-2 mr-2">Print PDF</a>
            </div>
            <ss-grid-pagination
                class="col-lg-4 mb-2"
                v-bind:current_page="current_page"
                v-bind:last_page="last_page"
                v-bind:total="total"
                v-on:goto-page="getData(...arguments)"
            >
            </ss-grid-pagination>
            <ss-grid-pagination-location
                class="col-lg-4 text-lg-right mb-2"
                v-bind:current_page="current_page"
                v-bind:last_page="last_page"
                v-bind:total="total"
            >
            </ss-grid-pagination-location>
        </div>
        <!-- end Grid Actions Bottom -->
    </div>
</template>

<script>
export default {
    props: {
        params: {
            type: Object,
            default: function() {}
        }
    },

    mounted: function() {
        this.params.Page = !isNaN(parseInt(this.params.Page))
            ? parseInt(this.params.Page)
            : null;
        this.query = this.params.Search;
        this.current_page = this.params.Page;
        this.getData(1);
    },

    data: function() {
        return {
            gridState: "wait",
            query: this.params.Search,
            gridData: [],
            current_page: this.params.Page,
            last_page: null,
            total: null,

            sortOrder: this.params.sortOrder,
            sortKey: this.params.sortKey,

            global_error_message: null
        };
    },

    methods: {
        goToNew: function() {
            window.location.href = "/role/create";
        },

        sortColumn: function(obj) {
            this.sortKey = obj.sortField;
            this.sortOrder = obj.sortOrder;
            this.getData(1);
        },

        getData: function(new_page_number) {
            this.global_error_message = null;

            let getPage;

            getPage =
                this.getDataUrl(new_page_number) +
                "&column=" +
                this.sortKey +
                "&direction=" +
                this.sortOrder;

            this.gridData = [];
            this.gridState = "wait";

            if (getPage != null) {
                // We have a filter
                axios
                    .get(getPage)
                    .then(response => {
                        this.gridData = response.data.data;
                        this.total = response.data.total;
                        this.current_page = response.data.current_page;
                        this.last_page = response.data.last_page || 1;
                        this.gridState = "good";
                    })
                    .catch(error => {
                        if (error.response && error.response.status == 422) {
                            this.fld_errors = error.response.data.errors;
                        } else {
                            this.gridState = "error";
                            this.global_error_message =
                                "Error, please try again. If error persists please report.";
                        }
                    })
                    .then(() => {});
            }
        },

        getDataUrl: function(new_page_number) {
            var url = "api-role?";
            var queryParams = [];

            queryParams.push("page=" + new_page_number);

            if (this.isDefined(this.query) && this.query.trim().length > 0)
                queryParams.push("keyword=" + this.query);

            //                if (this.isDefined(this.searchType)) queryParams.push('search_type=' + this.searchType);
            //                if (this.isDefined(this.showFilter)) queryParams.push('show_filter=' + this.showFilter);
            //                if (this.isDefined(this.contractorSelected)) queryParams.push('contractor_id=' + this.contractorSelected);

            if (queryParams.length > 0) url += queryParams.join("&");

            return url;
        }
    }
};
</script>
