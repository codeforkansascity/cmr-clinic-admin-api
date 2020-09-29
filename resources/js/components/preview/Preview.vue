<template>
    <div class="container pro-se">

        <!--  ------------------ -->
        <!--  T H E    T H I N G -->
        <!--  ------------------ -->


        <h1>Petition Information</h1>

        <p>IN THE <pre-api-input-field
            :applicant-id="this.record.id"
            :petition-number="1"
            field="case_heading"
            default-value="16TH CIRCUIT JUDICIAL CIRCUIT, JACKSON COUNTY, MISSOURI"
        />
        </p>

        <h1>Applicant Information</h1>

        <div style="margin-bottom: 1em">


            <div class="row">
                <div class="col-md-6" style="padding-left: 1em;">
                    <table class="table  table-sm">
                        <tr is="tr-view" v-model="record.name">Full Name</tr>
                        <tr is="tr-view" v-model="record.sex">Sex</tr>
                        <tr is="tr-view" v-model="record.race">Race</tr>
                        <tr is="tr-view-date" v-model="record.dob">Date of birth?</tr>

                    </table>
                </div>
                <div class="col-md-6" style="padding-left: 1em;">

                    <h5>Driver’s License</h5>

                    <table class="table  table-sm">
                        <tr is="tr-view" v-model="record.license_number">License number</tr>
                        <tr is="tr-view" v-model="record.license_issuing_state">Issuing state</tr>
                        <tr is="tr-view-date" v-model="record.license_expiration_date">Expiration date</tr>
                        <tr is="tr-view" v-model="record.cdl_status.name">CDL License</tr>
                        <tr is="tr-view" v-model="record.cdl_text">CDL Note</tr>

                    </table>

                </div>
                <div class="col-md-6" style="padding-left: 1em;">

                    <h5>Current Address</h5>

                    <table class="table  table-sm">
                        <tr is="tr-view" v-model="record.address_line_1">Address Line 1</tr>
                        <tr is="tr-view" v-model="record.address_line_2">Address Line 2</tr>
                        <tr>
                            <td style="width: 10em; color: darkgray">City/State/Zip</td>
                            <td>
                                {{ record.city }}
                                {{ record.state }}
                                {{ record.zip_code }}
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="col-md-6" style="padding-left: 1em;">

                    <h5>Previous Expungements</h5>

                    <table class="table  table-sm">
                        <tr is="tr-view" v-model="record.previous_felony_expungements">Felony</tr>
                        <tr is="tr-view" v-model="record.previous_misdemeanor_expungements">Misdemeanor</tr>
                        <tr is="tr-view" v-model="record.previous_expungements">Notes</tr>
                    </table>

                </div>
            </div>
        </div>

        <h1>Charges to Expunge</h1>



            <span v-for="(group, group_number) in this.expungebles[this.petition_index]" style="padding-top: 2em;">
                <h5 class="text-center">Group {{ group_number }}</h5>
                <table class="table mb-0 pro-se">
                    <thead>
                    <tr>
                    <th style="vertical-align: top;">Case Number</th>
                    <th style="vertical-align: top;">Approx. Date of Charge</th>
                    <th style="vertical-align: top;">Offense Description<br>(RSMo. Number and Common Name of Offense)</th>
                    <th style="vertical-align: top;">Reason Included in Group</th>
                    </tr>
                    </thead>


                    <tr v-for="row in group" :key="row.id">
                        <td style="width: 9em">{{ row.case_number }}</td>
                        <td><dsp-date v-model="row.date_of_charge"></dsp-date></td>
                        <td>{{ row.statue_number }} {{ row.statue_name }}</td>
                        <td>
                            <span
                                v-if="row.group_sequence == 1">Highest Offense - {{ row.conviction_charge_type }}</span>
                            <span v-else>Lesser Charge</span>
                        </td>
                    </tr>
                </table>
            </span>


        <h1>Service</h1>

        <p>
            MISSOURI DEPARTMENT OF REVENUE</br>
            301 W. High Street, Room 670</br>
            P.O. Box 475</br>
            Jefferson City, Missouri 65105-0475,</br>
        </p>
        <p>
            MISSOURI STATE HIGHWAY PATROL</br>
            Records Repository</br>
            1510 East Elm Street</br>
            Jefferson City, Missouri 65101,
        </p>
        <p>
            MISSOURI DEPARTMENT OF CORRECTIONS</br>
            2729 Plaza Drive</br>
            P.O. Box 236</br>
            Jefferson City, MO 65102,
        </p>

        <div v-for="row in this.serviceList" :key="row.id">
            <p>
            {{ row.name }}<br>
            {{ row.address }}<br>
            <span v-if="row.address_line_2">{{ row.address_line_2}}<br></span>
            {{ row.city }}, {{ row.state }} {{ row.zip }}<br>
            </p>
        </div>

        <h1>Signature Block</h1>

        <p>
            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_name"
                default-value="«SignatureBlockName»"
            />
        </p>
        <p>
            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_firm"
                default-value="«SignatureBlockFirm»"
            />
        </p>

        ______________________

        <p>

            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_bar_number_or_pro_se"
                default-value="«SignatureBlockBarNumberOrProSe»"
            />
            <br/>
            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_address"
                default-value="«SignatureBlockAddress»"
            />
            <br/>
            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_phone"
                default-value="«SignatureBlockPhone»"
            />
            <br/>
            <pre-api-input-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_email"
                default-value="«SignatureBlockEmail»"
            />

        </p>

        <h1>Charges not being expunged</h1>

        <table class="table mb-0">
            <thead>
            <tr>

                <th style="vertical-align: top;">Case Number</th>
                <th style="vertical-align: top;">Approx. Date of Charge</th>
                <th style="vertical-align: top;">Offense Description<br>(RSMo. Number and Common Name of Offense)</th>
                <th style="vertical-align: top;">Status</th>
            </tr>
            </thead>


            <tr v-for="row in this.notSelectedToExpunge" :key="row.id">

                <td style="width: 9em">{{ row.case_number }}</td>
                <td><dsp-date v-model="row.date_of_charge"></dsp-date></td>
                <td>{{ row.statue_number }} {{ row.statue_name }}</td>
                <td>{{ row.convicted }}<br>{{ row.eligible }}</td>
            </tr>
        </table>


    </div>
</template>

<script>

    export default {
        name: "applicant-preview",
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,
                        name: null,
                        step_id: null
                    }
                },
            },
            expungebles: {
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,
                    }
                },
            },
            notSelectedToExpunge:{
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,
                    }
                },
            },
            serviceList:{
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,
                    }
                },
            },
        },
        data() {
            return {
                petition_index: 1,
                record: {
                    blank: ''
                }
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
        },
        computed: {
            has_previous_expungements() {
                return this.record.previous_felony_expungements + this.record.previous_misdemeanor_expungements;
            }
        },
    }
</script>

