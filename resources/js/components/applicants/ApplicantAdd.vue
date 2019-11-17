<template>
    <div>
        <div class="row" v-if="mode=='select'">
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToSS"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add by Spread Sheet</a>

            </div>
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToCMS"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add from CMS</a>

            </div>
            <div class="col-md-4">
                <a
                        href="#"
                        @click.default="goToNew"
                        class="btn btn-primary mb-3 mb-sm-2 mr-3"
                >Add Manually</a>
            </div>
        </div>
        <div class="row" v-if="mode=='SS'">
            add by ss
        </div>
    </div>
</template>

<script>


    export default {
        name: "applicant-show",
        data: function () {
            return {
                mode: 'select'
            }
        },
        methods: {
            goToSS: function () {
                this.mode = 'SS';
            },
            goToCMS: function () {
                alert('CMS not implemented yet');
            },

            goToNew: function () {
                window.location.href = "/applicant/create";
            },


        }
    }
</script>

