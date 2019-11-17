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
                <input type="hidden" ref="newCharge">

                <div class="row pb-3">
                    <div class="col-md-11">
                        <std-form-group
                                label="Charge"
                                label-for="statute_id"
                                :errors="form_errors.statute_id"
                        >
                            <div class="alert alert-danger w-75" role="alert"
                                 v-if="isUndefinedOrEmpty(record.statute_id)">
                                Imported Statute: {{ record.imported_citation }} {{ record.imported_statute }}
                                <button type="button" class="close" @click="record.imported_statute = null">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <fld-statute
                                    name="statute_id"
                                    v-model="record.statute_id"
                                    @input="statuteSelected"
                            ></fld-statute>
                        </std-form-group>
                    </div>

                    <div class="col-md-1">
                        <slot></slot>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <std-form-group
                                label="Charge Type"
                                label-for="conviction_charge_type"
                                :errors="form_errors.conviction_charge_type"
                        >
                            <fld-charge-type
                                    name="conviction_charge_type"
                                    v-model="record.conviction_charge_type"
                            />
                        </std-form-group>
                    </div>
                    <div class="col-md-2">
                        <std-form-group
                                label="Class"
                                label-for="conviction_class_type"
                                :errors="form_errors.conviction_class_type"
                        >
                            <fld-charge-class
                                    name="conviction_class_type"
                                    v-model="record.conviction_class_type"
                            />
                        </std-form-group>

                    </div>
                    <div class="col-md-8">
                        <std-form-group
                                label="Sentence"
                                label-for="sentence"
                                :errors="form_errors.sentence"
                        >
                            <fld-input name="sentence" v-model="record.sentence"/>
                        </std-form-group>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <std-form-group
                                label="Convicted"
                                label-for="convicted"
                                :errors="form_errors.convicted"
                        >
                            <fld-convicted name="convicted" v-model="record.convicted"/>
                        </std-form-group>
                    </div>

                    <div class="col-md-3">
                        <std-form-group
                                label="Eligible"
                                label-for="eligible"
                                :errors="form_errors.eligible"
                        >
                            <fld-eligible name="eligible" v-model="record.eligible"/>
                        </std-form-group>
                    </div>

                    <div class="col-md-3">
                        <std-form-group
                                label="Please Expunge"
                                label-for="please_expunge"
                                :errors="form_errors.please_expunge"
                        >
                            <fld-expunge
                                    name="please_expunge"
                                    v-model="record.please_expunge"
                            />
                        </std-form-group>
                    </div>

                    <div class="col-md-3">

                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <std-form-group
                                label="Notes"
                                label-for="notes"
                                :errors="form_errors.notes"
                        >
                            <fld-text-editor name="notes" v-model="record.notes" rows="5"/>
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


                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col-md-4 text-md-left mt-2 mt-md-0">
                            <button class="btn btn-secondary" @click.prevent="cancel">Cancel</button>
                        </div>
                        <div class="col-md-4 text-center mt-2 mt-md-0" v-if="record.id > 0">
                            <button class="btn btn-danger" @click.prevent="deleteCharge">Delete Charge</button>
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

    export default {
        name: "charge-edit",
        model: {
            prop: 'modelValue',  // Rename v-model's input value to modelValue
                                 // We will use the default 'input' event for v-model
        },
        props: {
            modelValue: {        // Need to define the v-model input value prop
                type: Object,
            },
        },
        data() {
            return {
                record: {
                    statute: {}
                },         // We will store v-model's input here to be reactive
                form_errors: {
                    id: false,
                    conviction_id: false,
                    statute_id: false,
                    imported_statute: false,
                    imported_citation: false,
                    conviction_class_type: false,
                    conviction_charge_type: false,
                    sentence: false,
                    to_print: false,
                    notes: false,
                    convicted: false,
                    eligible: false,
                    please_expunge: false
                },
                server_message: false,
                try_logging_in: false,
                processing: false,
                isShowing: false,
                backup_copy: {},
                statutes: [],
            };
        },
        mounted() {
            this.getStatutes()
        },
        created() {

            // Copy v-model's input into a reactive store
            Object.keys(this.modelValue).forEach(i =>
                this.$set(this.record, i, this.modelValue[i])
            );

            /// make back up copy
            for (let index in this.charge) {
                this.backup_copy[index] = this.charge[index]
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
                    url = "/charge/" + this.record.id;
                    amethod = "put";
                } else {
                    url = "/charge";
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
                            if (res.data.charge) {
                                /// set id in case this is a new entry
                                $this.record.id = res.data.charge.id
                                if (res.data.charge.statute) {
                                    $this.record.statute = {};
                                    Object.keys(res.data.charge.statute).forEach(
                                        i => ($this.record.statute[i] = res.data.charge.statute[i])
                                    );
                                }
                            }
                            /// reset reason for change
                            $this.record.reason_for_change = ''
                            /// recopy the new charge to our backup
                            for (let index in $this.record) {
                                $this.backup_copy[index] = $this.record[index]
                            }


                            if (!$this.isDefined($this.record.statute)) {
                                $this.record.statute = {};
                            }

                            if (res.data.statute) {
                                Object.keys(res.data.statute).forEach(
                                    i => ($this.record.statute[i] = res.data.statute[i])
                                );
                            }

                            $this.processing = false;
                            this.$emit('input', $this.record);      // emit the changed record to v-model
                            $this.$bus.$emit('minimize-charge', $this.record.id)
                            if (res.data.charge) {
                                $this.$bus.$emit('adding-new-charge', $this.record)
                            }
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
                                window.location = "/charge";
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
            deleteCharge() {
                let $this = this
                if (confirm('Do you want to delete record?')) {
                    axios.delete(`/charge/${this.record.id}`)
                        .then(response => {
                            // send delete event to Charges List

                            this.$bus.$emit('charge-deleted', $this.record.id)
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

                if (this.record.id === 0) {
                    this.$bus.$emit('charge-deleted', 0)
                } else {
                    this.$bus.$emit('minimize-charge', this.record.id)
                }
            },
            getStatutes() {
                axios.get('/statutes/all')
                    .then(res => {
                        if (res.data) {
                            this.statutes = res.data
                            // this.statute_numbers = this.statutes.map(s => s.number)
                        }
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            statuteSelected(statute) {
                console.log('selected')
                this.record.imported_statute = null
            }
        }
    };
</script>
