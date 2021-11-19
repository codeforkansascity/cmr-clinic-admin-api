<template>
<div>
    <div class="grid no-more-tables table-responsive mb-4">
        <table class="table table-striped table-hover mb-0">
            <thead>
            <tr>
                <th>Statute  #</th>
                <th>Name</th>
                <th>Excption</br>Applies</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in statutes" :key="row.id">
                <td>
                    <a :href="'/statute/' + row.statute_id" target="_blank">
                    {{ row.statute_number }}
                    </a>
                    </td>
                    <td>
                    <span v-if="row.statute_common_name">
                                {{ row.statute_common_name }}
                    </span>
                    <span v-else>
                                {{ row.statute_name }}
                    </span>

                    <div v-if="row.note" class="indented-block">
                        {{ row.note }}
                    </div>
                    <div v-if="row.statute_note" class="indented-block">
                        {{ row.statute_note }}
                    </div>
                </td>
                <td>
                    {{ row.exception_code }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<script>
export default {
    props: {
        statutes: {
            type: [Boolean, Object],
            default: false
        }
    },
    name: "DspExceptionStatutes"
}
</script>

