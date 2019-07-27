<template>
    <div class="grid no-more-tables table-responsive mb-4">
        <table class="table table-striped table-hover mb-0">
            <thead>
            <tr>
                <th style="width:50%;">
                    <!-- TODO: no initial sort class/style applied -->
                    <a
                            href="#"
                            @click.prevent="sortBy('Name')"
                            v-bind:class="{ active: sortKey == 'Name' }"
                            title="Sort by name"
                    >
                        Organization Name<span
                            class="arrow"
                            v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'"
                    >
                            </span>
                    </a>
                </th>
                <th style="width:20%;">
                    <a
                            href="#"
                            @click.prevent="sortBy('City')"
                            v-bind:class="{ active: sortKey == 'City' }"
                            title="Sort by city"
                    >
                        City<span
                            class="arrow"
                            v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'"
                    >
                            </span>
                    </a>
                </th>
                <th style="width:10%;">
                    <a
                            href="#"
                            @click.prevent="sortBy('State')"
                            v-bind:class="{ active: sortKey == 'State' }"
                            title="Sort by state"
                    >
                        State<span
                            class="arrow"
                            v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'"
                    >
                            </span>
                    </a>
                </th>
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
                        No matching organizations were found.
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
                            v-bind:href="'/organization/' + row.id"
                            v-if="params.CanShow == '1'"
                    >
                        {{ row.name }}
                    </a>
                    <span v-if="params.CanShow != '1'">
                            {{ row.name }}
                        </span>
                </td>
                <td data-title="City">{{ row.city }}</td>
                <td data-title="State">{{ row.state }}</td>
                <td data-title="Actions" class="text-lg-center text-nowrap">
                    <a
                            v-bind:href="'/organization/' + row.id"
                            v-if="params.CanShow == '1'"
                            class="grid-action-item"
                    >
                        View
                    </a>
                    <a
                            v-bind:href="'/organization/' + row.id + '/edit'"
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
</template>

<script>
    export default {
        name: "ss-grid-rows",
        data: function () {
            return {
                gridState: "wait"
            };
        }
    };
</script>

<style scoped></style>
