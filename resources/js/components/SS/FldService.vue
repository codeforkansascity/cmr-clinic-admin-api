/*

DEAD CODE DEAD CODE ????
id: 1,
name: "Brennon Cole",
address: """
6564 Alessandro Junctions\n
Coltonfurt, TX 12532
""",
phone: "730.377.3592",
email: "amorissette@gmail.com",
note: "Corrupti quia soluta dolores fugiat ut dolores quae sint. Id atque aut ut quam. Iusto magni dolorem labore dolores.",
service_type_id: 1,
deleted_at: null,
*/

<template>
    <div>
        <autocomplete
            ref="autocomplete"
            url="/services/all"
            :create="true"
            :value="value"
            valueField="number"
            displayField="name"
            @selected="serviceSelected"
            @input="updateService"
            @create="showModal = true"
        ></autocomplete>
        <base-modal v-if="showModal" @close="showModal = false">
            <template v-slot:header>Create New Statute</template>
            <template v-slot:body>

                <div class="form-group">
                    <label class="font-weight-bold">Number</label>
                    <input type="text" required class="form-control" placeholder="Statute Number"
                           v-model="newStatute.number">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Name</label>
                    <input type="text" required class="form-control" v-model="newStatute.name"
                           placeholder="Statute Name">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Is Expungeable?</label>
                    <select class="form-control" v-model="newStatute.statutes_eligibility_id">
                        <option value="">--Select--</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                        <option value="3">Possibly</option>
                    </select>
                </div>
            </template>
            <template v-slot:footer>
                <button class="btn btn-secondary float-left" @click.prevent="showModal = false">Cancel</button>
                <button type="submit" class="btn btn-primary float-right" @click.prevent="createService">Submit</button>
            </template>
        </base-modal>

    </div>
</template>


<script>
    export default {
        name: "fld-service",
        props: {
            value: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                showModal: false,
                newService: {
                    id: null,
                    name: null,
                    address: null,
                    phone: null,
                    email: null,
                    note: null,
                    service_type_id: null,
                    deleted_at: null,
                }
            }
        },
        methods: {
            serviceSelected(v) {
                this.$emit('selected', v)
            },
            createService() {
                console.log('create service')
                let $this = this
                axios.post('/service', {
                    statutes_eligibility_id: this.newStatute.statutes_eligibility_id,
                    name: this.newService.name,
                    number: this.newService.number
                }).then(res => {
                    console.log(res)
                    $this.serviceSelected($this.newStatute)
                    $this.updateService($this.newStatute.number)
                    $this.showModal = false
                    $this.$refs.autocomplete.getData()
                }).catch(e => {
                    console.error(e)
                })
            },
            updateService(v) {
                this.$emit('input', v)
            }
        }
    }
</script>

<style scoped>

</style>
