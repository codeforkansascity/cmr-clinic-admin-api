<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center2">
                <h1 class="text-center">{{record.number}} {{ record.name}}</h1>


            </div>

            <div class="col-md-12 text-center2">
                <h1 class="text-center">
                    <span v-if="record.statutes_eligibility_id == '0'">
                        Undetermined Eligibility
                    </span>
                    <span v-else-if="record.statutes_eligibility.name != 'Eligible'" style="color:red">
                        {{record.statutes_eligibility.name}}
                    </span>
                    <span v-else>
                        {{record.statutes_eligibility.name}}
                    </span>

                </h1>
                <h5 class="text-center">{{ jurisdiction }}</h5>


            </div>
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
                        Exception
                    </label>
                    <div class="col-md-8">
                       <ul style="list-style-type: none; padding: 0; margin: 0; font-size: 1.1rem;">
                           <li v-for="(exception,i)  in exceptions" :key="exception.id"
                               >
                               <dsp-exception :exception="exception"/>

                           </li>
                       </ul>

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
