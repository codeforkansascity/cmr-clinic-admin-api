<template>
    <div>
        <fieldset class="mb-4">
            <legend>General Information</legend>
            <div class="row">
                <div class="col-md-6">

        [[foreach:columns]]
        [[if:i.type!='id']]
                <div class="form-group row mb-2 mb-md-0 text-only">
                    <label class="col-md-4 col-form-label text-md-right">
                        [[i.display]]
                    </label>
                    <div class="col-md-8">
                        <dsp-text v-model="record.[[i.name]]"/>
                    </div>
                </div>
        [[endif]]
        [[endforeach]]

                </div>
            </div>
        </fieldset>
    </div>
</template>

<script>
    export default {
        name: "[[route_path]]-show",
        props: {
            record: {
                type: [Boolean, Object],
                default: false,
            },
        },
    };
</script>
