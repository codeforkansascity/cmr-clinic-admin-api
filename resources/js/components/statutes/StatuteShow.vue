<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center2">
                <h1 class="text-center">{{record.number}} {{ record.name}}</h1>


            </div>

<!--            <div class="col-md-12 text-center2">-->
<!--                <h1 class="text-center">-->
<!--                    <span v-if="record.statutes_eligibility_id == '0'">-->
<!--                        Undetermined Eligibility-->
<!--                    </span>-->
<!--                    <span v-else-if="record.statutes_eligibility.name != 'Eligible'" style="color:red">-->
<!--                        {{record.statutes_eligibility.name}}-->
<!--                    </span>-->
<!--                    <span v-else>-->
<!--                        {{record.statutes_eligibility.name}}-->
<!--                    </span>-->

<!--                </h1>-->
<!--                <h5 class="text-center">{{ jurisdiction }}</h5>-->


<!--            </div>-->
            <div class="col-md-12">


                <div class=" row mb-2 mb-md-0 text-only">
                    <label class="col-md-4  text-md-right" style="font-size: 1.1rem; color: darkgray" >
                        Common Name
                    </label>
                    <div class="col-md-8"  style="font-size: 1.1rem">
                        {{record.common_name}}
                    </div>
                </div>

                <div class=" row mb-2 mb-md-0 text-only">
                    <label class="col-md-4  text-md-right" style="font-size: 1.1rem; color: darkgray" >
                        Superseded by
                    </label>
                    <div v-if="isSuperseded" class="col-md-8" style="font-size: 1.1rem">
                        {{ record.superseded.number}} {{ record.superseded.name}} on {{ record.superseded_on}}
                    </div>

                </div>

                <div class=" row mb-2 mb-md-0 text-only">
                    <label class="col-md-4  text-md-right" style="font-size: 1.1rem; color: darkgray" >
                        Note
                    </label>
                    <div class="col-md-8" style="font-size: 1.1rem">
                        <dsp-textarea v-model="record.note"/>
                    </div>
                </div>
                <div class=" row mb-2 mb-md-0 text-only">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10">
                        <h3>Charge Codes</h3>
                        <table class="table">
                            <tr>
                                <th>Charge Code</th>
                                <th>Level</th>
                                <th>Description</th>
                                <th>sor</th>
                                <th>FPrint</th>
                            </tr>
                            <tbody>
                            <tr v-for="(code,i)  in chargeCodes" :key="chargeCodes.id">
                                <td>{{ code.charge_code }}</td>
                                <td>{{ code.type_class }}</td>
                                <td>{{ code.description  }}</td>
                                <td>{{ code.sor }}</td>
                                <td>{{ code.cmr_charge_code_fingerprintable }}</td>

                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class=" row mb-2 mb-md-0 text-only">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10">
                        <h3>Exceptions</h3>
                       <dl style="list-style-type: none; padding: 0; margin: 0; font-size: 1.1rem;" v-for="(exception,i)  in exceptions" :key="exception.id"
                               >

                           <dt>
                               {{ exception.exception_section }}

                               <span v-if="exception.code == 'Applies'" style="color:red">
                                   {{ exception.code }}
                               </span>

                               <span v-else-if="exception.code == 'Does Not Apply'" style="color:green">
                                   {{ exception.code }}
                               </span>

                               <span v-else-if="exception.code == 'Undetermined'" style="color:darkgrey">
                                   {{ exception.code }}
                               </span>


                               <span v-else>
                                   {{ exception.code }}
                               </span>

                           </dt>
                           <dd>

                               {{ exception.exception_name }}
                               <div v-if="exception.exception_note" class="indented-block ml-4">
                                   {{ exception.exception_note }}
                               </div>
                               <div v-if="exception.exception_attorney_note" class="indented-block ml-4">
                                   <span style="color: lightgray;">Atty Instructions:</span> {{ exception.exception_attorney_note }}
                               </div>

                               <div v-if="exception.exception_dyi_note" class="indented-block ml-4">
                                   <span style="color: lightgray;">DYI Instructions:</span> {{ exception.exception_dyi_note }}
                               </div>

                           </dd>

                       </dl>

                    </div>
                </div>




            </div>
        </div>
<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <h5>Used in</h5>-->
<!--                <table class="table">-->
<!--                    <tr v-for="row in charges" :key="row.id">-->
<!--                        <td>-->
<!--                            {{ row.conviction.applicant.name }}-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            {{ row.conviction.case_number }}-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            {{ row.conviction_charge_type}}-->
<!--                            {{ row.conviction_class_type}}-->
<!--                        </td>-->
<!--                    </tr>-->


<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
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
            },
            chargeCodes: {
                type: [Boolean, Object, Array],
                default: false
            },
            exceptions: {
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
<style>

dl {
    padding-left: 200px;
}

dt {
    display: inline-block;
    margin-right: 5px;
    text-indent: -200px;
}

dd {
    display: inline;
    word-break: break-all;
    margin-inline-start: 0;
}

dd::after {
    content: "\a";
    white-space: pre;
    display: block;
}

dd:last-child::after {
    content: "";
}
</style>
