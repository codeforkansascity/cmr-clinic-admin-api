<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Statute
                    </label>
                    <div class="col-md-8">
                        {{record.number}} {{ record.name}}
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Jurisdiction
                    </label>
                    <div class="col-md-8">
                        {{ jurisdiction }}
                    </div>
                </div>
                <div v-if="isSuperseded" class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Superseded by
                    </label>
                    <div class="col-md-8">
                        {{ record.superseded.number}} {{ record.superseded.name}} on {{ record.superseded_on}}
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Eligible
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.statutes_eligibility.name"/>
                    </div>
                </div>
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        Note
                    </label>
                    <div class="col-md-8">
                        <dsp-textarea v-model="record.note"/>
                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Used in</h5>
                <table class="table">
                    <tr v-for="row in charges" :key="row.id">
                        <td>
                            {{ row.conviction.applicant.name }}
                        </td>
                        <td>
                            {{ row.conviction.case_number }}
                        </td>
                        <td>
                            {{ row.conviction_charge_type}}
                            {{ row.conviction_class_type}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "statute-show",
        props: {
            record: {
                type: [Boolean, Object],
                default: false
            },
            charges: {
                type: [Boolean, Object, Array],
                default: false
            }
        },
        computed: {
            jurisdiction: function () {
                var type;
                var jurisdiction;
                type = '';
                jurisdiction = '';
                if (this.record.jurisdiction) {
                    jurisdiction = this.record.jurisdiction.name;
                    if (this.record.jurisdiction.type) {
                        type = this.record.jurisdiction.type.name;
                        return type + ' - ' + jurisdiction;
                    }
                } else {
                    return jurisdiction;
                }

                return '';

            },
            isSuperseded: function () {
                if (this.record.superseded) {
                    return true;
                }
                return false;
            }
        }

    };
</script>
