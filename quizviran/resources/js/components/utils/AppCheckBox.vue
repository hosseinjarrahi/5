<template>
  <div class="custom-control custom-checkbox my-1 mr-sm-2">

    <input type="checkbox"
           @input="select"
           :name="name"
           :value="checked"
           class="custom-control-input"
           :id="`checkbox-${random}`">

    <label class="custom-control-label" :for="`checkbox-${random}`">
      <slot></slot>
    </label>

  </div>
</template>

<script>
    export default {
        name: "AppCheckBox",
        props: {
            'name': {default: ''},
            'qid': {default: ''}
        },
        data() {
            return {
                random: null,
                checked: false
            }
        },
        methods: {

            makeid(length) {
                let result = '';
                let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let charactersLength = characters.length;
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            },

            select() {
                this.$emit('change', {
                    selected: this.qid
                });
                this.checked = !this.checked;
            }
        },
        created() {
            this.random = this.makeid(10);
        }
    }
</script>

<style scoped>

</style>
