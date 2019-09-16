<template>
<div>
    <autocomplete
        url="/statutes/all"
        :create="true"
        :value="value"
        valueField="number"
        displayField="name"
        @selected="statuteSelected"
        @input="updateStatute"
        @create="showModal = true"
    ></autocomplete>
    <base-modal v-if="showModal" @close="showModal = false">
        <template v-slot:header>Create New Statute</template>
        <template v-slot:body>

            <div class="form-group">
                <label class="font-weight-bold">Number</label>
                <input type="text" required class="form-control"placeholder="Statute Number" v-model="newStatute.number">
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Name</label>
                <input type="text" required class="form-control" v-model="newStatute.name" placeholder="Password">
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Is Expungeable?</label>
                <select class="form-control" v-model="newStatute.eligibility">
                    <option value="">--Select--</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                    <option value="3">Possibly</option>
                </select>
            </div>
        </template>
        <template v-slot:footer>
            <button class="btn btn-secondary float-left" @click.prevent="showModal = false">Cancel</button>
            <button type="submit" class="btn btn-primary float-right" @click.prevent="createStatute">Submit</button>
        </template>
    </base-modal>

</div>
</template>


<script>
    export default {
        name: "FldStatute",
        props: {
            value: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                showModal: false,
                newStatute: {
                    name: null,
                    number: null,
                    eligibility: null,
                }
            }
        },
        methods: {
            statuteSelected(v) {
                this.$emit('selected', v)
            },
            createStatute() {
                console.log('create statute')
                let $this = this
                axios.post('/statute', {
                    statutes_eligibility_id: this.newStatute.eligibility,
                    name: this.newStatute.name,
                    number: this.newStatute.number
                }).then(res => {
                    console.log(res)
                    $this.statuteSelected($this.newStatute)
                    $this.updateStatute($this.newStatute.number)
                    $this.showModal = false
                }).catch(e => {console.error(e)})
            },
            updateStatute(v) {
                this.$emit('input', v)
            }
        }
    }
</script>

<style scoped>

</style>
