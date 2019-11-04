/**

For text area
=====================

<dsp-statute v-model="PostData.statute"/>


*/

<template>

    <span v-if="value.id">
        <span>
            {{ value.number }} {{ value.name }} ({{value.statutes_eligibility.name}})
            <span v-if="hasNote" style="margin-left: 3em; font-size: smaller">
                <a href="#" @click="displayNote">See Note</a>
            </span>
        </span>
        <div v-if="superseded" style="margin-left: 3em; font-size: smaller">
            Superseded by {{ superseded }}
        </div>
    </span>

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

        }
    }
</script>
