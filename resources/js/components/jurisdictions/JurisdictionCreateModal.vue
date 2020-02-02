<template>
    <base-modal v-if="showModal" @close="showModal = false">
        <template v-slot:header>Create New Jursidiction</template>
        <template v-slot:body>


            <div class="form-group">
                <label class="font-weight-bold">Type</label>
                <v-select label="name"
                          :filterable="false"
                          v-model="selected_jurisdiction_type"
                          :options="jurisdiction_types"
                >
                </v-select>
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Name</label>
                <fld-input name="name" v-model="name"/>
            </div>
        </template>
        <template v-slot:footer>
            <button class="btn btn-secondary float-left" @click.prevent="showModal = false">Cancel</button>
            <button type="submit" class="btn btn-primary float-right" @click.prevent="save">Submit</button>
        </template>
    </base-modal>

</template>

<script>
    export default {
        name: "JurisdictionCreateModal",
        data() {
            return {
                selected_jurisdiction_type: null,
                jurisdiction_types: [],
                name: null,
                showModal: false,
            }
        },
        created() {
            this.getJurisdictionTypes()
        },
        methods: {
            getJurisdictionTypes() {
                axios.get('/api-jurisdiction-type')
                    .then((res) => {
                        this.jurisdiction_types = res.data.data
                    })
                    .catch(e => console.error(e))
            },
            save() {
                axios.post('/api-jurisdiction', {
                    jurisdiction_type_id: this.selected_jurisdiction_type.id,
                    name: this.name,
                }).then(res => {
                    this.$emit('add', res.data)
                    this.showModal = false
                }).catch(e => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>
