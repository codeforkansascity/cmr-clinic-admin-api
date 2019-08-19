<template>
    <div>
        <img    v-if="show"
                height="30"
                src="/img/icons/noun_Chevron double Up_2648915.png"
                @click="toggle"/>
        <img    v-if="!show"
                height="30"
                src="/img/icons/noun_Chevron double down_2648933.png"
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
            this.trueIcon = this.icons[this.icon][true]
            this.falseIcon = this.icons[this.icon][false]
        },
        data() {
          return {
              icons: {
                  chevron: [
                      "/img/icons/noun_Chevron double down_2648933.png",
                      "/img/icons/noun_Chevron double Up_2648915.png"
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