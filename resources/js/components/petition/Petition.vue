<template>
<div>
    <div class="row  my-5">
        <div id="download-area" class="mx-auto">
            <button class="btn btn-lg btn-primary" @click="handleExport">Export as a Word Document</button>
        </div>
    </div>

    <div id="hiddenlink" style="display:none">
        <a id="hiddena" style="display:none"></a>
    </div>

    <div class="container pro-se" id="petitionDocument" style="font-family: Arial;font-size: 12pt;line-height: 2;">
        <!--  ------------------ -->
        <!--  T H E    T H I N G -->
        <!--  ------------------ -->

        <div class="row">
            <div class="col-12">
                <p style="font-family: Arial; font-size: 12pt;text-decoration-line: underline; text-align: center; padding-bottom: 2em">

                    IN THE
                    <pre-api-field
                        :applicant-id="this.record.id"
                        :petition-number="1"
                        field="case_heading"
                        default-value="16TH CIRCUIT JUDICIAL CIRCUIT, JACKSON COUNTY, MISSOURI"
                    />
                </p>
            </div>
            <br/>

        </div>
        <div style="margin-top: 3em">
            <table class="equalDivide" cellpadding="0" cellspacing="0" width="100%" border="0">
                <tr border="0">
                    <td style="vertical-align: top; border-right: 2px solid black; border-collapse: collapse; "
                        width="50%">
                        <div>
                            <p style="font-family: Arial;font-size: 12pt;line-height: 1;">
                                <pre-field v-model="record.name" capitalize="true" missing_prompt="«Name»"/>
                                ,<br>

                            </p>

                            <p style="font-family: Arial;font-size: 12pt;line-height: 1.2; padding-left: 10em; padding-bottom: 2em">

                                Petitioner
                            </p>

                            <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                                vs.
                            </p>

                            <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                                MISSOURI DEPARTMENT OF REVENUE</br>
                                301 W. High Street, Room 670</br>
                                P.O. Box 475</br>
                                Jefferson City, Missouri 65105-0475,</br>
                            </p>
                            <br/>
                            <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                                MISSOURI STATE HIGHWAY PATROL</br>
                                Records Repository</br>
                                1510 East Elm Street</br>
                                Jefferson City, Missouri 65101,
                            </p>
                            <br/>
                            <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                                MISSOURI DEPARTMENT OF CORRECTIONS</br>
                                2729 Plaza Drive</br>
                                P.O. Box 236</br>
                                Jefferson City, MO 65102,
                            </p>

                            <div v-for="row in this.serviceList" :key="row.id">
                                <br/>
                                <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                                    {{ row.name.toUpperCase() }}<br>
                                    {{ row.address }}<br>
                                    <span v-if="row.address_line_2">{{ row.address_line_2 }}<br></span>
                                    {{ row.city }}, {{ row.state }} {{ row.zip }}<br>
                                </p>
                            </div>

                            <p style="font-family: Arial;font-size: 12pt;line-height: 1; padding-left: 10em; padding-top: 1em">
                                Respondents.
                            </p>
                        </div>
                    </td>

                    <td border="0" width="50%" style="padding-left: 2em">
                        <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                            Case No.:
                        </p>
                        <p style="font-family: Arial;font-size: 12pt;line-height: 1.2;">
                            Div. 00
                        </p>
                    </td>
                </tr>
            </table>

        </div>

        <div style="clear: both; padding-top:2em">
            <p style="font-family: Arial; font-size: 12pt;text-decoration-line: underline; text-align: center;">
                PETITION FOR EXPUNGEMENT
            </p>
            <div class="pro-se-dbl" style="font-family: Arial;font-size: 12pt;line-height: 2;">
                <p>
                    COMES NOW Petitioner,
                    <pre-field v-model="record.name" missing_prompt="«PetitionerCurrentNameFull»"/>
                    ,
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
                    />
                    ,
                    and petitions the Court to
                    expunge records of arrest, plea, trial, or conviction and all related records pertaining to
                    offenses,
                    violations, or infractions described below as provided for by § 610.140 RSMo. (2016 & Supp.
                    2019)
                    (effective Aug. 28, 2019) and for the issuance of an
                    order to expunge Petitioner’s records. In support of the petition, Petitioner states:
                </p>
                <ol>
                    <li> Petitioner resides at
                        <pre-address-field v-model="record" missing_prompt="«PetitionerAddressFull»"/>
                        .
                    </li>
                    <li> Petitioner’s date of birth is
                        <pre-date-field v-model="record.dob" missing_prompt="«DateOfBirth»"/>
                        ,
                        gender is
                        <pre-field v-model="record.sex" missing_prompt="«Gender»"/>
                        ,
                        and race is
                        <pre-field v-model="record.race" missing_prompt="«Race»"/>
                        .
                    </li>
                    <li> Petitioner’s driver’s license or other state issued identification was issued by
                        <pre-field v-model="record.license_issuing_state" missing_prompt="«DriversLicenseST»"/>
                        ,
                        identifying number
                        <pre-field v-model="record.license_number" missing_prompt="«DriversLicenseNumber»"/>
                        ,
                        expiration date
                        <pre-date-field v-model="record.license_expiration_date"
                                        missing_prompt="«DriversLicenseExpiration»"/>
                        .
                    </li>
                    <li> ** Petitioner requests expungement of the following offenses, violations, or infractions,
                        grouped
                        together where charged as counts in the same indictment, information, or ticket or where
                        cases
                        share
                        a common course of conduct:
                    </li>

                    <span v-for="(group, group_number) in this.expungebles[this.petition_index]"
                          style="padding-bottom: 2em; margin-bottom: 2em;">


                            <h5 v-if="number_of_groups > 1"
                                class="text-center">
                                Group {{ group_number }}
                            </h5>
                            <table style="border: 1px solid black; border-collapse: collapse; width: 90%">
                                <thead>
                                <tr>
                                <th style="width: 7em; vertical-align: bottom; horiz-align: center; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em">Case Number</th>
                                <th style="width: 7em; vertical-align: bottom; horiz-align: center; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em">Approx. Date of Charge</th>
                                <th style="vertical-align: bottom; horiz-align: center; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em">Offense Description</th>
                                <th style="width: 10em; vertical-align: bottom; horiz-align: center; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em"
                                    v-if="group.length > 1">Reason Included in Group</th>
                                </tr>
                                </thead>


                                <tr v-for="row in group" :key="row.id">
                                    <td style="vertical-align: top; border: 1px solid black; border-collapse: collapse; width: 9em; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em">{{
                                            row.case_number
                                        }}</td>
                                    <td style="vertical-align: top; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em"><dsp-date
                                        v-model="row.date_of_charge"></dsp-date></td>
                                    <td style="vertical-align: top; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em">{{
                                            row.statue_number
                                        }} {{ row.statue_name }}</td>
                                    <td style="vertical-align: top; border: 1px solid black; border-collapse: collapse; font-family: Arial; font-size: 12pt; padding-left: 0.25em; padding-right: 0.25em"
                                        v-if="group.length > 1">
                                        <span
                                            v-if="row.group_sequence == 1">Highest Offense - {{
                                                row.conviction_charge_type
                                            }}</span>
                                        <span v-else>Lesser Charge</span>
                                    </td>
                                </tr>
                            </table>

                    </span>

                    <br/>
                    <li> ** None of the offenses, violations, or infractions for which Petitioner seeks expungement
                        are
                        excluded by § 610.140.2 RSMo.
                    </li>
                    <li v-if="has_previous_expungements">
                        **
                        <pre-field v-model="record.previous_expungements"
                                   missing_prompt="«PreviousExpungementLanguage»"/>
                        [Petitioner was granted a previous expungement on (date of expungement) in ( ) County,
                        Missouri, of the following offense(s) (prior offenses), (a felony, misdemeanor, or
                        infraction).
                        If
                        granted expungement as sought in this case, Petitioner will not exceed the maximum
                        limitations
                        of
                        § 610.140.12 RSMo.
                    </li>
                    <li v-if="!has_previous_expungements">
                        ** Petitioner has not previously been granted an expungement in this
                        state, and expungement of these offenses, violations, or infractions will not exceed the
                        maximum
                        lifetime limitations of § 610.140.12 RSMo.
                    </li>
                    <li v-if="record.cdl_status_id == 1"> None of the aforesaid arrests or convictions involved the
                        operation of a commercial vehicle and
                        Petitioner is not a holder of a commercial driver’s license, nor is he required to possess a
                        commercial driver’s license by this state or any other state.
                    </li>
                    <li> ** Petitioner completed the authorized disposition for the offense sought to be expunged on
                        [Offense
                        Completion Date] [or] Petitioner completed the authorized disposition for Offense A on
                        [Offense
                        A Completion Date] and for Offense B on [Offense B Completion Date].
                    </li>
                    <li> The appropriate amount of time has elapsed since completion of the authorized
                        disposition imposed for each offense that Petitioner is seeking to have expunged, in that it
                        has
                        been at least seven (7) years since completion of any felony offense or at least three (3)
                        years
                        since
                        completion of any misdemeanor, infraction, or ordinance violation.
                    </li>
                    <li> ** Petitioner has not been found guilty of any other misdemeanor or felony, not including
                        violations
                        of the traffic regulations provided under chapters 304 and 307, RSMo. during the time period
                        specified for the underlying [offense violation, or infraction] in § 610.140.1 RSMo.
                    </li>
                    <li> Petitioner has satisfied all obligations relating to any such disposition, including the
                        payment of
                        any fines and restitution.
                    </li>
                    <li> Petitioner does not have any charges pending.</li>
                    <li> Petitioner’s habits and conduct demonstrate that the Petitioner is not a threat to the
                        public
                        safety of the State.
                    </li>
                    <li> This expungement is consistent with the public welfare and the interests of justice warrant
                        the
                        expungement.
                    </li>
                    <li> Petitioner has reason to believe that Respondents may possess records subject to
                        expungement.
                    </li>

                </ol>
                WHEREFORE, Petitioner respectfully requests that (1) the offenses, violations, or infractions set
                forth
                in this petition be expunged pursuant to § 610.140 RSMo.; (2) that the Court enter an Order of
                Expungement
                of all records and files maintained by any and all named Respondents related to those offenses,
                violations,
                or infractions ; (3) that, pursuant to § 610.140 RSMo., the Court provide a certified copy of the
                Order of
                Expungement to Petitioner and each named Respondent; (4) that, pursuant to § 610.140.7 RSMo., each
                named
                Respondent be ordered to close any record in its possession relating to any offense, violation, or
                infraction listed in this Petition; (5) that, consistent with § 610.140.8, RSMo., Petitioner be
                restored
                to the status occupied prior to such arrest, plea, trial, and/or conviction[s] as if such had not
                taken
                place; and (6) for such further relief as the Court deems proper.
            </div>
            <p style="font-family: Arial;font-size: 12pt;">
                Respectfully Submitted,
            </p>

            <p>
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_name"
                    default-value="«SignatureBlockName»"
                    style="font-family: Arial;font-size: 12pt;"
                />
            </p>


            ______________________

            <p>

                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_bar_number_or_pro_se"
                    default-value="«SignatureBlockBarNumberOrProSe»"
                    style="font-family: Arial;font-size: 12pt;"
                />
                <br/>
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_address"
                    default-value="«SignatureBlockAddress»"
                    style="font-family: Arial;font-size: 12pt;"
                />
                <br/>
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_phone"
                    default-value="«SignatureBlockPhone»"
                    style="font-family: Arial;font-size: 12pt;"
                />
                <br/>
                <pre-api-field
                    :applicant-id="this.record.id"
                    :petition-number="1"
                    field="signature_block_email"
                    default-value="«SignatureBlockEmail»"
                    style="font-family: Arial;font-size: 12pt;"
                />

            </p>
        </div>

    </div>
</div>
</template>

<script>
// import htmlDocx from 'html-docx-js/dist/html-docx';
var htmlDocx = require('html-docx-js/dist/html-docx');

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
        handleExport() {
            let doc = document.getElementById('petitionDocument')
            let converted = htmlDocx.asBlob(doc.innerHTML)
            this.createDownload(converted)
        },
        createDownload(file) {
            // hiddenlink
            //let link = document.createElement('a');
            let link = document.getElementById('hiddena')
            link.href = URL.createObjectURL(file);
            link.download = 'document.docx';
            link.appendChild(
                document.createTextNode('Export as Word Doc'));

            let downloadArea = document.getElementById('download-area');
            downloadArea.appendChild(link);
            link.click()
        },
    }
}
</script>

