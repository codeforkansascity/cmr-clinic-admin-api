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
                    label="Cmr Charge Code Seq"
                    label-for="cmr_charge_code_seq"
                    :errors="form_errors.cmr_charge_code_seq"
                >
                    <fld-input
                        name="cmr_charge_code_seq"
                        v-model="form_data.cmr_charge_code_seq"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Charge Code Fingerprintable"
                    label-for="cmr_charge_code_fingerprintable"
                    :errors="form_errors.cmr_charge_code_fingerprintable"
                >
                    <fld-input
                        name="cmr_charge_code_fingerprintable"
                        v-model="form_data.cmr_charge_code_fingerprintable"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Charge Code Effective Year"
                    label-for="cmr_charge_code_effective_year"
                    :errors="form_errors.cmr_charge_code_effective_year"
                >
                    <fld-input
                        name="cmr_charge_code_effective_year"
                        v-model="form_data.cmr_charge_code_effective_year"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Charge Code Ncic Category"
                    label-for="cmr_charge_code_ncic_category"
                    :errors="form_errors.cmr_charge_code_ncic_category"
                >
                    <fld-input
                        name="cmr_charge_code_ncic_category"
                        v-model="form_data.cmr_charge_code_ncic_category"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Cmr Charge Code Ncic Modifier"
                    label-for="cmr_charge_code_ncic_modifier"
                    :errors="form_errors.cmr_charge_code_ncic_modifier"
                >
                    <fld-input
                        name="cmr_charge_code_ncic_modifier"
                        v-model="form_data.cmr_charge_code_ncic_modifier"
                    />
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
                    label="Ncic Mod"
                    label-for="ncic_mod"
                    :errors="form_errors.ncic_mod"
                >
                    <fld-input name="ncic_mod" v-model="form_data.ncic_mod" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="State Mod"
                    label-for="state_mod"
                    :errors="form_errors.state_mod"
                >
                    <fld-input name="state_mod" v-model="form_data.state_mod" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Description"
                    label-for="description"
                    :errors="form_errors.description"
                >
                    <fld-input
                        name="description"
                        v-model="form_data.description"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Type Class"
                    label-for="type_class"
                    :errors="form_errors.type_class"
                >
                    <fld-input
                        name="type_class"
                        v-model="form_data.type_class"
                    />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Dna"
                    label-for="dna"
                    :errors="form_errors.dna"
                >
                    <fld-input name="dna" v-model="form_data.dna" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Sor"
                    label-for="sor"
                    :errors="form_errors.sor"
                >
                    <fld-input name="sor" v-model="form_data.sor" />
                </std-form-group>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <std-form-group
                    label="Roc"
                    label-for="roc"
                    :errors="form_errors.roc"
                >
                    <fld-input name="roc" v-model="form_data.roc" />
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
                    <a
                        href="/import-mshp-charge-code-manual"
                        class="btn btn-default"
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
    name: "import-mshp-charge-code-manual-form",
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
                cmr_charge_code_seq: "",
                cmr_charge_code_fingerprintable: "",
                cmr_charge_code_effective_year: "",
                cmr_charge_code_ncic_category: "",
                cmr_charge_code_ncic_modifier: "",
                charge_code: "",
                ncic_mod: "",
                state_mod: "",
                description: "",
                type_class: "",
                dna: "",
                sor: "",
                roc: "",
                case_type: "",
                effective_date: null
            },
            form_errors: {
                id: false,
                mshp_version_id: false,
                cmr_law_number: false,
                cmr_chapter: false,
                cmr_charge_code_seq: false,
                cmr_charge_code_fingerprintable: false,
                cmr_charge_code_effective_year: false,
                cmr_charge_code_ncic_category: false,
                cmr_charge_code_ncic_modifier: false,
                charge_code: false,
                ncic_mod: false,
                state_mod: false,
                description: false,
                type_class: false,
                dna: false,
                sor: false,
                roc: false,
                case_type: false,
                effective_date: false
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
                url = "/import-mshp-charge-code-manual/" + this.form_data.id;
                amethod = "put";
            } else {
                url = "/import-mshp-charge-code-manual";
                amethod = "post";
            }
            await axios({
                method: amethod,
                url: url,
                data: this.form_data
            })
                .then(res => {
                    if (res.status === 200) {
                        window.location = "/import-mshp-charge-code-manual";
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
                            window.location = "/import-mshp-charge-code-manual";
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
