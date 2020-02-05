/**

For text area
=====================

<dsp-statute v-model="PostData.statute"/>


*/

<template>

    <div v-if="value.id" style="padding-left: 5em; text-indent: -5em ;">
        <span>
            {{ value.number }} {{ value.name }}
             <span v-if="not_state_jurisdiction" style="color: lightsteelblue">
                [{{ not_state_jurisdiction }}]
            </span>
            ({{value.statutes_eligibility.name}})
            <span v-if="hasNote" style="margin-left: 3em; font-size: smaller">
                <a href="#" @click="displayNote">See Note</a>
            </span>
            <span v-if="isMoStatute" style="margin-left: 1em; font-size: smaller">
                <a href="#" @click="displayMoRevisor">Mo Statute</a>
            </span>
        </span>
        <div v-if="superseded" style="margin-left: 3em; font-size: smaller">
            Superseded by {{ superseded }}
        </div>
    </div>

</template>

<script>
    export default {
        name: 'dsp-statute',
        props: {
            value: {
                default: null
            }
        },
        methods: {
            displayNote: function () {
                if (!this.isUndefinedOrEmpty(this.value.id)) {
                    window.open("/statute/" + this.value.id, "_blank");
                } else {
                    alert('Cannot find statute')
                }
                return false;
            },
            displayMoRevisor: function () {
                if (!this.isUndefinedOrEmpty(this.value.number)) {
                    window.open("http://revisor.mo.gov/main/OneSection.aspx?section=" + this.value.number, "_blank");
                } else {
                    alert('Cannot find statute')
                }
                return false;
            }
        },
        computed: {
            // a computed getter
            superseded: function () {
                if (!this.isUndefinedOrEmpty(this.value.superseded)) {
                    return this.value.superseded.number + ' ' + this.value.superseded.name;
                }
                return false;
            },
            hasNote: function () {
                return (!this.isUndefinedOrEmpty(this.value.note));
                // return !( this.value.note === '' || this.value.note === null);
            },
            isMoStatute: function () {
                if (!this.isUndefinedOrEmpty(this.value.number)) {
                    var regx = /^\d\d\d\.\d\d\d$/;
                    var found = this.value.number.match(regx);

                    if (found) {
                        return true;
                    }
                }
                return false;
            },
            not_state_jurisdiction: function () {

                if (this.value.jurisdiction && this.value.jurisdiction.name != 'Missouri') {
                    return this.value.jurisdiction.name;
                } else {
                    return null;
                }
            }
        }
    }
</script>
