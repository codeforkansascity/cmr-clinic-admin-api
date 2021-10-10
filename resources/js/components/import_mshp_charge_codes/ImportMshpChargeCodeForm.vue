<template>
    <form @submit.prevent="handleSubmit" class="form-horizontal">
        <div
            v-if="server_message !== false"
            class="alert alert-danger"
            role="alert"
        >
            {{ this.server_message }}
            <a v-if="try_logging_in" href="/login">Login</a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Id"
                    label-for="id"
                    :errors="form_errors.id"
                >
                    <fld-input name="id" v-model="form_data.id" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Mshp Version Id"
                    label-for="mshp_version_id"
                    :errors="form_errors.mshp_version_id"
                >
                    <fld-input
                        name="mshp_version_id"
                        v-model="form_data.mshp_version_id"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Law Number"
                    label-for="cmr_law_number"
                    :errors="form_errors.cmr_law_number"
                >
                    <fld-input
                        name="cmr_law_number"
                        v-model="form_data.cmr_law_number"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Chapter"
                    label-for="cmr_chapter"
                    :errors="form_errors.cmr_chapter"
                >
                    <fld-input
                        name="cmr_chapter"
                        v-model="form_data.cmr_chapter"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Legacy Charge Code"
                    label-for="legacy_charge_code"
                    :errors="form_errors.legacy_charge_code"
                >
                    <fld-input
                        name="legacy_charge_code"
                        v-model="form_data.legacy_charge_code"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Charge Type"
                    label-for="charge_type"
                    :errors="form_errors.charge_type"
                >
                    <fld-input
                        name="charge_type"
                        v-model="form_data.charge_type"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Classification"
                    label-for="classification"
                    :errors="form_errors.classification"
                >
                    <fld-input
                        name="classification"
                        v-model="form_data.classification"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Effective Date"
                    label-for="effective_date"
                    :errors="form_errors.effective_date"
                >
                    <fld-input
                        name="effective_date"
                        v-model="form_data.effective_date"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Inactive Date"
                    label-for="inactive_date"
                    :errors="form_errors.inactive_date"
                >
                    <fld-input
                        name="inactive_date"
                        v-model="form_data.inactive_date"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Reportable"
                    label-for="reportable"
                    :errors="form_errors.reportable"
                >
                    <fld-input
                        name="reportable"
                        v-model="form_data.reportable"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Short Description"
                    label-for="short_description"
                    :errors="form_errors.short_description"
                >
                    <fld-input
                        name="short_description"
                        v-model="form_data.short_description"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Not Applicable"
                    label-for="not_applicable"
                    :errors="form_errors.not_applicable"
                >
                    <fld-input
                        name="not_applicable"
                        v-model="form_data.not_applicable"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Attempt"
                    label-for="attempt"
                    :errors="form_errors.attempt"
                >
                    <fld-input name="attempt" v-model="form_data.attempt" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Accessory"
                    label-for="accessory"
                    :errors="form_errors.accessory"
                >
                    <fld-input name="accessory" v-model="form_data.accessory" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Conspiracy"
                    label-for="conspiracy"
                    :errors="form_errors.conspiracy"
                >
                    <fld-input
                        name="conspiracy"
                        v-model="form_data.conspiracy"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Code Category"
                    label-for="code_category"
                    :errors="form_errors.code_category"
                >
                    <fld-input
                        name="code_category"
                        v-model="form_data.code_category"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Ncic Category"
                    label-for="ncic_category"
                    :errors="form_errors.ncic_category"
                >
                    <fld-input
                        name="ncic_category"
                        v-model="form_data.ncic_category"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Statute"
                    label-for="statute"
                    :errors="form_errors.statute"
                >
                    <fld-input name="statute" v-model="form_data.statute" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Long Description"
                    label-for="long_description"
                    :errors="form_errors.long_description"
                >
                    <fld-input
                        name="long_description"
                        v-model="form_data.long_description"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Uniform Citation Ind"
                    label-for="uniform_citation_ind"
                    :errors="form_errors.uniform_citation_ind"
                >
                    <fld-input
                        name="uniform_citation_ind"
                        v-model="form_data.uniform_citation_ind"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Rec Of Conviction"
                    label-for="rec_of_conviction"
                    :errors="form_errors.rec_of_conviction"
                >
                    <fld-input
                        name="rec_of_conviction"
                        v-model="form_data.rec_of_conviction"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Case Type"
                    label-for="case_type"
                    :errors="form_errors.case_type"
                >
                    <fld-input name="case_type" v-model="form_data.case_type" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Charge Code"
                    label-for="charge_code"
                    :errors="form_errors.charge_code"
                >
                    <fld-input
                        name="charge_code"
                        v-model="form_data.charge_code"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Dna At Arrest"
                    label-for="dna_at_arrest"
                    :errors="form_errors.dna_at_arrest"
                >
                    <fld-input
                        name="dna_at_arrest"
                        v-model="form_data.dna_at_arrest"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="form-group mt-4">
            <div class="row">
                <div class="col-md-6">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        :disabled="processing"
                    >
                        <span v-if="this.form_data.id"
                            >Change Charge Codes</span
                        >
                        <span v-else="this.form_data.id">Add Charge Codes</span>
                    </button>
                </div>
                <div class="col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="/import-mshp-charge-code" class="btn btn-default"
                        >Cancel</a
                    >
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";

export default {
    name: "import-mshp-charge-code-form",
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
    data() {
        return {
            form_data: {
                // _method: 'patch',
                _token: this.csrf_token,
                id: 0,
                mshp_version_id: 0,
                cmr_law_number: "",
                cmr_chapter: "",
                legacy_charge_code: "",
                charge_type: "",
                classification: "",
                effective_date: null,
                inactive_date: null,
                reportable: "",
                short_description: "",
                not_applicable: "",
                attempt: "",
                accessory: "",
                conspiracy: "",
                code_category: "",
                ncic_category: "",
                statute: "",
                long_description: "",
                uniform_citation_ind: "",
                rec_of_conviction: "",
                case_type: "",
                charge_code: "",
                dna_at_arrest: ""
            },
            form_errors: {
                id: false,
                mshp_version_id: false,
                cmr_law_number: false,
                cmr_chapter: false,
                legacy_charge_code: false,
                charge_type: false,
                classification: false,
                effective_date: false,
                inactive_date: false,
                reportable: false,
                short_description: false,
                not_applicable: false,
                attempt: false,
                accessory: false,
                conspiracy: false,
                code_category: false,
                ncic_category: false,
                statute: false,
                long_description: false,
                uniform_citation_ind: false,
                rec_of_conviction: false,
                case_type: false,
                charge_code: false,
                dna_at_arrest: false
            },
            server_message: false,
            try_logging_in: false,
            processing: false
        };
    },
    mounted() {
        if (this.record !== false) {
            // this.form_data._method = 'patch';
            Object.keys(this.record).forEach(i =>
                this.$set(this.form_data, i, this.record[i])
            );
        } else {
            // this.form_data._method = 'post';
        }
    },
    methods: {
        async handleSubmit() {
            this.server_message = false;
            this.processing = true;
            let url = "";
            let amethod = "";
            if (this.form_data.id) {
                url = "/import-mshp-charge-code/" + this.form_data.id;
                amethod = "put";
            } else {
                url = "/import-mshp-charge-code";
                amethod = "post";
            }
            await axios({
                method: amethod,
                url: url,
                data: this.form_data
            })
                .then(res => {
                    if (res.status === 200) {
                        window.location = "/import-mshp-charge-code";
                    } else {
                        this.server_message = res.status;
                    }
                })
                .catch(error => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            // Clear errors out
                            Object.keys(this.form_errors).forEach(i =>
                                this.$set(this.form_errors, i, false)
                            );
                            // Set current errors
                            Object.keys(error.response.data.errors).forEach(i =>
                                this.$set(
                                    this.form_errors,
                                    i,
                                    error.response.data.errors[i]
                                )
                            );
                        } else if (error.response.status === 404) {
                            // Record not found
                            this.server_message = "Record not found";
                            window.location = "/import-mshp-charge-code";
                        } else if (error.response.status === 419) {
                            // Unknown status
                            this.server_message =
                                "Unknown Status, please try to ";
                            this.try_logging_in = true;
                        } else if (error.response.status === 500) {
                            // Unknown status
                            this.server_message =
                                "Server Error, please try to ";
                            this.try_logging_in = true;
                        } else {
                            this.server_message = error.response.data.message;
                        }
                    } else {
                        console.log(error.response);
                        this.server_message = error;
                    }
                    this.processing = false;
                });
        }
    }
};
</script>
