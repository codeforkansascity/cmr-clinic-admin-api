<template>
    <div>
        <img    v-if="show"
                height="30"
                :src="trueIcon"
                @click="toggle"/>
        <img    v-if="!show"
                height="30"
                :src="falseIcon"
                @click="toggle"/>
    </div>
</template>

<script>
    export default {
        name: "content-toggle",
        props: {
            show: {
                type: Boolean,
                default: false,
            },
            icon: {
                type: String,
                default: 'chevron'
            }

        },
        created() {
            this.trueIcon = this.icons[this.icon][1]
            this.falseIcon = this.icons[this.icon][0]
        },
        data() {
          return {
              icons: {
                  double_chevron: [
                      "/img/icons/noun_Chevron double down_2648933.png",
                      "/img/icons/noun_Chevron double Up_2648915.png"
                  ],
                  chevron: [
                      "/img/icons/noun_chevron_2768142.png",
                      "/img/icons/noun_chevron_2768158.png"
                  ],
                  pencil: [
                      "resources/img/icons/noun_Pencil_2768160.png",
                      ""
                  ]


              },
              trueIcon: null,
              falseIcon: null
          }
        },
        methods: {
            toggle() {
                this.$emit('click')
            }
        }
    }
</script>

<style scoped>

</style>