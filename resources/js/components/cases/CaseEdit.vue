<template>
    <div>
        <div
                v-if="server_message !== false"
                class="alert alert-danger"
                role="alert"
        >
            {{ this.server_message }}
            <a v-if="try_logging_in" href="/login">Login</a>
        </div>

        <div>
            <form @submit.prevent="handleSubmit" class="form-horizontal">

                <div class="row">
                    <div class="col-md-6" style="padding-left: 2em;">

                        <div class="col-md-12">
                            <std-form-group
                                    label="Case number?"
                                    label-for="case_number"
                                    :errors="form_errors.case_number"
                                    :required="true"
                            >
                                <fld-input name="case_number" v-model="record.case_number" :required="true"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Case Description?"
                                    label-for="name"
                                    :errors="form_errors.name"
                            >
                                <fld-input name="name" v-model="record.name"/>
                                <template slot="help">
                                    When speaking with the expungie, how they refer to this. "Car 2005".
                                    Until someone meets with the expungie, a short but meaningful description.
                                </template>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Applicant's name in court’s records?"
                                    label-for="record_name"
                                    :errors="form_errors.record_name"

                            >
                                <fld-input name="record_name" v-model="record.record_name"/>
                                <template slot="help">
                                    Applicant's name as it appeared on the court’s records.
                                </template>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Arresting Agency?"
                                    label-for="arresting_agency"
                                    :errors="form_errors.record_name"

                            >
                                <fld-input name="arresting_agency" v-model="record.arresting_agency"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Date of arrest (Approximate)?"
                                    label-for="arrest_date"
                                    :errors="form_errors.arrest_date"

                            >
                                <fld-input name="arrest_date" v-model="record.arrest_date"/>
                                <template slot="help">
                                    Any format is ok, even just a year.
                                </template>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Date of Charge "
                                    label-for="date_of_charge"
                                    :errors="form_errors.date_of_charge"

                            >

                                <flat-pickr
                                        v-model="record.date_of_charge"

                                        :config="config"
                                        style="width: 10em"/>
                            </std-form-group>
                        </div>

                        <!--<div class="col-md-12">-->
                        <!--<std-form-group-->
                        <!--label="Was the court a Missouri circuit (county) court or a municipal (city) court?"-->
                        <!--label-for="agency"-->
                        <!--:errors="form_errors.agency"-->
                        <!--:required="true"-->
                        <!--&gt;-->
                        <!--<fld-input name="agency" v-model="record.agency"/>-->
                        <!--</std-form-group>-->
                        <!--</div>-->
                    </div>

                    <!--=====================-->
                    <div class="col-md-6">

                        <div class="col-md-12">
                            <std-form-group
                                    label="Date of Disposition (Approximate) "
                                    label-for="date_of_disposition"
                                    :errors="form_errors.date_of_disposition"

                            >
                                <fld-input name="date_of_disposition"
                                           v-model="record.date_of_disposition"/>
                                <template slot="help">
                                    Any format is ok, even just a year.
                                </template>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Release Status"
                                    label-for="release_status"
                                    :errors="form_errors.release_status"

                            >
                                <fld-input name="release_status" v-model="record.release_status"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Release Date"
                                    label-for="release_date"
                                    :errors="form_errors.release_date"

                            >
                                <flat-pickr
                                        v-model="record.release_date"

                                        :config="config"
                                        style="width: 10em"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Court"
                                    label-for="court_city_county"
                                    :errors="form_errors.court_city_county"

                            >
                                <fld-input name="court_city_county" v-model="record.court_city_county"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Judge"
                                    label-for="judge"
                                    :errors="form_errors.judge"

                            >
                                <fld-input name="judge" v-model="record.judge"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="SIS"
                                    label-for="sis"
                                    :errors="form_errors.sis"

                            >
                                <fld-checkbox name="sis" v-model="record.sis"/>
                            </std-form-group>
                        </div>
                    </div>

                    <div class="col-md-12" style="padding-left: 2em;">
                        <div class="col-md-4">
                            <std-form-group
                                    label="Source"
                                    label-for="source"
                                    :errors="form_errors.source"

                            >
                                <fld-source-select v-model="record.sources"></fld-source-select>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Notes"
                                    label-for="notes"
                                    :errors="form_errors.notes"

                            >
                                <fld-text-editor name="notes" v-model="record.notes" style="height: 20em"/>
                            </std-form-group>
                        </div>

                        <div class="col-md-12">
                            <std-form-group
                                    label="Reason for Change"
                                    label-for="reason_for_change"
                                    :errors="form_errors.reason_for_change"
                            >
                                <fld-text-area
                                        name="reason_for_change"
                                        v-model="record.reason_for_change"
                                        required
                                        rows="5"
                                />
                            </std-form-group>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col-md-4 text-md-left mt-2 mt-md-0">
                            <button class="btn btn-secondary" @click.prevent="cancel">Cancel</button>
                        </div>
                        <div class="col-md-4 text-center mt-2 mt-md-0" v-if="record.id > 0">
                            <button class="btn btn-danger" @click.prevent="deleteCase">Delete Case</button>
                        </div>
                        <div class="col-md-4 text-md-right">
                            <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="processing"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        name: "CaseEdit",
        components: {
            flatPickr
        },
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
            },
            config: {
                type: Object,
                default: function () {
                    return {
                        altInput: true,
                        altFormat: "m/d/Y",
                        dateFormat: "Y-m-d",
                        allowInput: true,
                    }
                },
            }
        },
        data() {
            return {
                record: {},         // We will store v-model's input here to be reactive
                form_errors: {
                    id: false,
                    applicant_id: false,
                    name: false,
                    arrest_date: false,
                    case_number: false,
                    agency: false,
                    court_name: false,
                    court_city_county: false,
                    judge: false,
                    record_name: false,
                    release_status: false,
                    release_date_text: false,
                    notes: false,
                    date_of_charge: false,
                    release_date: false,
                    reason_for_change: false
                },
                server_message: false,
                try_logging_in: false,
                processing: false,
                isShowing: false,
                backup_copy: {}
            };
        },

        created() {

            // Copy v-model's input into a reactive store
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );

            /// make back up copy
            for (let index in this.record) {
                this.backup_copy[index] = this.record[index]
            }
        },

        methods: {
            async handleSubmit() {
                let $this = this
                this.server_message = false;
                this.processing = true;
                let url = "";
                let amethod = "";
                if (this.record.id) {
                    url = "/conviction/" + this.record.id;
                    amethod = "put";
                } else {
                    url = "/conviction";
                    amethod = "post";
                }
                await axios({
                    method: amethod,
                    url: url,
                    data: this.record
                })
                    .then(res => {
                        if (res.status === 200) {
                            // if saved set the get the id back and set to instance
                            if (res.data.record) {
                                /// set id in case this is a new entry
                                $this.record.id = res.data.record.id
                                /// recopy the new record to our backup
                                for (let index in $this.record) {
                                    $this.backup_copy[index] = $this.record[index]
                                }
                            }

                            $this.processing = false;
                            this.$emit('input', $this.record);      // emit the changed record to v-model
                            $this.$bus.$emit('minimize-case', $this.record.id)
                        } else {
                            this.server_message = res.status;
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                // Clear errors out
                                Object.keys(this.form_errors).forEach(
                                    i => (this.form_errors[i] = false)
                                );
                                // Set current errors
                                Object.keys(error.response.data.errors).forEach(
                                    i =>
                                        (this.form_errors[i] =
                                            error.response.data.errors[i])
                                );
                            } else if (error.response.status === 404) {
                                // Record not found
                                this.server_message = "Record not found";
                                window.location = "/appliants";
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
            },
            deleteCase() {
                let $this = this
                if (confirm('Do you want to delete record?')) {
                    axios.delete(`/conviction/${this.record.id}`)
                        .then(response => {
                            console.log(response)
                            // send delete event to Charges List
                            this.$bus.$emit('case-deleted', this.record.id)
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            },
            cancel() {
                if (this.record.id !== 0) {
                    for (let index in this.backup_copy) {
                        this.record[index] = this.backup_copy[index]
                        this.record.reason_for_change = ''
                    }
                }
                //  since the minimize-case event goes to all case containers let's just skip that to avoid problems
                //  and send  to the case list delete to if 0
                //  otherwise we could namespace the event with the case id or key
                if (this.record.id === 0) {
                    this.$bus.$emit('case-deleted', 0)
                } else {
                    this.$bus.$emit('minimize-case', this.record.id)
                }
            }
        }
    };
</script>
