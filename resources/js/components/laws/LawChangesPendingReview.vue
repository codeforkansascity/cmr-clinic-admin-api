<template>
<div>
    Start
    <div class="grid no-more-tables table-responsive mb-4">
        <table class="table table-striped table-hover mb-0">
            <thead>
            <tr>
                <th>Started</th>
                <th>Created by</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in this.versions" :key="row.id">
                <td data-title="Created"><dsp-date-time v-model="row.start_date"/></td>
                <td data-title="Created By">{{ row.created_by_name }}</td>
                <td data-title="Reason">{{ row.reason_for_change }}</td>
                <td data-title="Status">{{ row.version_status }}</td>
                <td>
                    <a href="#" @click.default="goToView( row.id) " class="btn btn-primary mb-3 mb-sm-2 mr-3">View Version</a>

                </td>

            </tr>
            </tbody>

        </table>
    </div>
</div>

</template>

<script>
export default {
    name: "law-changes-pending-review",
    props: {
        versions: {
            type: [Boolean, Object, Array],
            default: false
        },
    },

    methods: {

        goToView: function (id) {
            console.log(id)
            window.location.href = '/law-version/' + id;
        },
    }
}
</script>

