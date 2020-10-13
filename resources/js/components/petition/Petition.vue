<template>
    <div class="container pro-se">

        <!--  ------------------ -->
        <!--  T H E    T H I N G -->
        <!--  ------------------ -->


        <p>IN THE
            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="case_heading"
                default-value="16TH CIRCUIT JUDICIAL CIRCUIT, JACKSON COUNTY, MISSOURI"
            />
        </p>
        <p>
            <pre-field v-model="record.name" capitalize="true" missing_prompt="«Name»"/>
            ,<br>
            Petitioner
        </p>

        <div class="row" style="margin-bottom: 2em;">
            <div class="col-sm">
                vs.
            </div>

            <div class="col-sm float-right">
                <span class="float-right">Case No. <pre-field v-model="record.case_no" capitalize="true"
                                                              missing_prompt="«CaseYear»"/>-CV</span>
            </div>
        </div>


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
                {{ row.name.toUpperCase() }}<br>
                {{ row.address }}<br>
                <span v-if="row.address_line_2">{{ row.address_line_2}}<br></span>
                {{ row.city }}, {{ row.state }} {{ row.zip }}<br>
            </p>
        </div>

        <p>
            Respondents.
        </p>

        <p style="text-decoration-line: underline; text-center">
            PETITION FOR EXPUNGEMENT
        </p>

        <div class="pro-se-dbl">
            <p>
                COMES NOW Petitioner,
                <pre-field v-model="record.name" missing_prompt="«PetitionerCurrentNameFull»"/>,
                by and through counsel
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_name"
                    default-value="«SignatureBlockName»"
                />
                of
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_firm"
                    default-value="«SignatureBlockFirm»"
                />,
                and petitions the Court to
                expunge records of arrest, plea, trial, or conviction and all related records pertaining to offenses,
                violations, or infractions described below as provided for by § 610.140 RSMo. (2016 & Supp. 2019) (effective Aug. 28, 2019) and for the issuance of an
                order to expunge Petitioner’s records. In support of the petition, Petitioner states:
            </p>
            <ol>
                <li> Petitioner resides at
                    <pre-address-field v-model="record" missing_prompt="«PetitionerAddressFull»"/>.
                </li>
                <li> Petitioner’s date of birth is
                    <pre-date-field v-model="record.dob" missing_prompt="«DateOfBirth»"/>,
                    gender is
                    <pre-field v-model="record.sex" missing_prompt="«Gender»"/>,
                    and race is
                    <pre-field v-model="record.race" missing_prompt="«Race»"/>.
                </li>
                <li> Petitioner’s driver’s license or other state issued identification was issued by
                    <pre-field v-model="record.license_issuing_state" missing_prompt="«DriversLicenseST»"/>,
                    identifying number
                    <pre-field v-model="record.license_number" missing_prompt="«DriversLicenseNumber»"/>,
                    expiration date
                    <pre-date-field v-model="record.license_expiration_date"
                                    missing_prompt="«DriversLicenseExpiration»"/>.
                </li>
                <li> ** Petitioner requests expungement of the following offenses, violations, or infractions, grouped
                    together where charged as counts in the same indictment, information, or ticket or where cases share
                    a common course of conduct:
                </li>

                <span v-for="(group, group_number) in this.expungebles[this.petition_index]" style="padding-top: 2em;">
                    <h5 v-if="number_of_groups > 1" class="text-center">Group {{ group_number }}</h5>
                    <table class="table mb-0 pro-se">
                        <thead>
                        <tr>
                        <th style="vertical-align: top;">Case Number</th>
                        <th style="vertical-align: top;">Approx. Date of Charge</th>
                        <th style="vertical-align: top;">Offense Description<br>(RSMo. Number and Common Name of Offense)</th>
                        <th v-if="group.length > 1" style="vertical-align: top;">Reason Included in Group</th>
                        </tr>
                        </thead>


                        <tr v-for="row in group" :key="row.id">
                            <td style="width: 9em">{{ row.case_number }}</td>
                            <td><dsp-date v-model="row.date_of_charge"></dsp-date></td>
                            <td>{{ row.statue_number }} {{ row.statue_name }}</td>
                            <td v-if="group.length > 1">
                                <span
                                    v-if="row.group_sequence == 1">Highest Offense - {{ row.conviction_charge_type }}</span>
                                <span v-else>Lesser Charge</span>
                            </td>
                        </tr>
                    </table>
                </span>


                <li> ** None of the offenses, violations, or infractions for which Petitioner seeks expungement are
                    excluded by § 610.140.2 RSMo.
                </li>
                <li v-if="has_previous_expungements">
                    **
                    <pre-field v-model="record.previous_expungements" missing_prompt="«PreviousExpungementLanguage»"/>
                    [Petitioner was granted a previous expungement on (date of expungement) in ( ) County,
                    Missouri, of the following offense(s) (prior offenses), (a felony, misdemeanor, or infraction). If
                    granted expungement as sought in this case, Petitioner will not exceed the maximum limitations of
                    § 610.140.12 RSMo.
                </li>
                <li v-if="!has_previous_expungements">
                    ** Petitioner has not previously been granted an expungement in this
                    state, and expungement of these offenses, violations, or infractions will not exceed the maximum
                    lifetime limitations of § 610.140.12 RSMo.
                </li>
                <li v-if="record.cdl_status_id == 1"> None of the aforesaid arrests or convictions involved the
                    operation of a commercial vehicle and
                    Petitioner is not a holder of a commercial driver’s license, nor is he required to possess a
                    commercial driver’s license by this state or any other state.
                </li>
                <li> ** Petitioner completed the authorized disposition for the offense sought to be expunged on
                    [Offense
                    Completion Date] [or] Petitioner completed the authorized disposition for Offense A on [Offense A
                    Completion Date] and for Offense B on [Offense B Completion Date].
                </li>
                <li> The appropriate amount of time has elapsed since completion of the authorized
                    disposition imposed for each offense that Petitioner is seeking to have expunged, in that it has
                    been at least seven (7) years since completion of any felony offense or at least three (3) years since
                    completion of any misdemeanor, infraction, or ordinance violation.
                </li>
                <li> ** Petitioner has not been found guilty of any other misdemeanor or felony, not including violations
                    of the traffic regulations provided under chapters 304 and 307, RSMo. during the time period
                    specified for the underlying [offense violation, or infraction] in § 610.140.1 RSMo.
                </li>
                <li> Petitioner has satisfied all obligations relating to any such disposition, including the payment of
                    any fines and restitution.
                </li>
                <li> Petitioner does not have any charges pending.</li>
                <li> Petitioner’s habits and conduct demonstrate that the Petitioner is not a threat to the public
                    safety of the State.
                </li>
                <li> This expungement is consistent with the public welfare and the interests of justice warrant the
                    expungement.
                </li>
                <li> Petitioner has reason to believe that Respondents may possess records subject to expungement.</li>

            </ol>
            WHEREFORE, Petitioner respectfully requests that (1) the offenses, violations, or infractions set forth in
            this petition be expunged pursuant to § 610.140 RSMo.; (2) that the Court enter an Order of Expungement of
            all records and files maintained by any and all named Respondents related to those offenses, violations, or
            infractions ; (3) that, pursuant to § 610.140 RSMo., the Court provide a certified copy of the Order of
            Expungement to Petitioner and each named Respondent; (4) that, pursuant to § 610.140.7 RSMo., each named
            Respondent be ordered to close any record in its possession relating to any offense, violation, or
            infraction listed in this Petition; (5) that, consistent with § 610.140.8, RSMo., Petitioner be restored to
            the status occupied prior to such arrest, plea, trial, and/or conviction[s] as if such had not taken place;
            and (6) for such further relief as the Court deems proper.
        </div>
        <p>
            Respectfully Submitted,
        </p>

        <p>
            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_name"
                default-value="«SignatureBlockName»"
            />
        </p>


        ______________________

        <p>

            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_bar_number_or_pro_se"
                default-value="«SignatureBlockBarNumberOrProSe»"
            />
            <br/>
            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_address"
                default-value="«SignatureBlockAddress»"
            />
            <br/>
            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_phone"
                default-value="«SignatureBlockPhone»"
            />
            <br/>
            <pre-api-field
                :applicant-id="this.record.id"
                :petition-number="1"
                field="signature_block_email"
                default-value="«SignatureBlockEmail»"
            />

        </p>


    </div>
</template>

<script>

    export default {
        name: "petition",
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
            serviceList: {
                type: [Boolean, Object, Array],
                default: () => {
                    return {
                        id: 0,
                    }
                },
            },
            petitionCount: {
                type: [Number, String],
                default: 0
            },
            groupCount: {
                type: [Number, String],
                default: 0
            },
            caseCount: {
                type: [Number, String],
                default: 0
            }
        },
        data() {
            return {
                petition_index: 1,
                record: {
                    blank: '',

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
            },
            number_of_groups() {
                return this.groupCount;
            },
            number_of_cases() {
                return this.caseCount;
            }
        },
        methods: {
            cap(a) {

            }
        }
    }
</script>

