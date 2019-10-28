<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-3 col-form-label text-md-right">
                            Name
                        </label>
                        <div class="col-md-9">
                            {{ record.name }}
                        </div>
                    </div>

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-3 col-form-label text-md-right">
                            Active
                        </label>
                        <div class="col-md-9">
                            <span v-if="record.active">
                                Yes
                            </span>
                        </div>
                    </div>

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-3 col-form-label text-md-right">
                            Email
                        </label>
                        <div class="col-md-9">
                            {{ record.email }}
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>

        <!--
        <fieldset class="mb-4">
            <legend>Activity</legend>
            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Email Verified At
                        </label>
                        <div class="col-md-8">
                            {{ record.email_verfiied_at }}
                        </div>
                    </div>

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Created At
                        </label>
                        <div class="col-md-8">
                            {{ record.created_at }}
                        </div>
                    </div>

                    <div class="form-group row mb-2 mb-md-0 text-only">
                        <label class="col-md-4 col-form-label text-md-right">
                            Updated At
                        </label>
                        <div class="col-md-8">
                            {{ record.updated_at }}
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>
        -->

    </div>
</template>

<script>
    export default {
        name: "user-show",
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
        },
    };
</script>
