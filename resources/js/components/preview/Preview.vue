<template>
    <div class="container pro-se">

        <!--  ------------------ -->
        <!--  T H E    T H I N G -->
        <!--  ------------------ -->


        <h1>Petition Information</h1>

        <p>IN THE <pre-input-field v-model="record.blank" capitalize="true" missing_prompt="«Case_Heading»"/>
        </p>

        <p style="color: red">ProSe question</p>

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



                <table class="table mb-0">
                    <thead>
                    <tr>
                    <th style="vertical-align: top;">Group</th>
                    <th style="vertical-align: top;">Case Number</th>
                    <th style="vertical-align: top;">Approx. Date of Charge</th>
                    <th style="vertical-align: top;">Offense Description<br>(RSMo. Number and Common Name of Offense)</th>
                    <th style="vertical-align: top;">Reason Included in Group</th>
                    </tr>
                    </thead>


                    <tr v-for="row in this.expungebles" :key="row.id">
                        <td align="center">{{ row.group_number }}</td>
                        <td style="width: 9em">{{ row.case_number }}</td>
                        <td>{{ row.approximate_date_of_charge_text }}</td>
                        <td>{{ row.statue_number }} {{ row.statue_name }}</td>
                        <td>
                            <span v-if="row.group_sequence == 1">Highest Offense - {{ row.conviction_charge_type }}</span>
                            <span v-else>Lesser Charge</span>
                        </td>
                    </tr>
                </table>


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
        <p>
            «ArrestingAgency»</br>
            «ArrestingAgencyServiceStreetAddress»</br>
            «ArrestingAgencyCitySTZIP»
        </p>
        <p>
            «JailEntity»</br>
            «JailAgencyServiceStreetAddress»</br>
            «JailAgencyServiceCitySTZIP»
        </p>
        <p>
            «ServiceProsecutorOfficeName»</br>
            «ProsecutorServiceStreetAddress»</br>
            «ProsecutorCitySTZIP»
        </p>
        <p>
            «CourtName»</br>
            «CourtServiceStreetAddress»</br>
            «CourtServiceCitySTZIP»
        </p>
        <p>
            «OtherAgenciesWithRecords»</br>
            «OtherPartyFullAddress»</br>
        </p>

        <h1>Signature Block</h1>

        <p>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockHeading»"/>
        </p>


        ______________________

        <p>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockName»"/><br>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockBarNumberOrProSe»"/><br>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockAddress»"/><br>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockCitySTZIP»"/><br>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockPhone»"/><br>
            <pre-input-field style="color: red" v-model="record.blank" missing_prompt="«SignatureBlockEmail»"/><br>
        </p>

        <h1>Charges not being expunged</h1>


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
            }
        },
        data() {
            return {
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

