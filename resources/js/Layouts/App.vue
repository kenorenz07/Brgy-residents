<template>
    <div>
        <router-view></router-view>
        <confirm ref="confirm"></confirm>
        <notification ref="notify"></notification>
    </div>
</template>
<script>
  import confirm from "../components/Confirm.vue"
  import notification from "../components/Notification.vue"
export default {
     components : {
      confirm,
      notification
    },
    mounted() {
      this.$root.$confirm = this.$refs.confirm.open
      this.$root.$notify = this.$refs.notify.open
    }
}
</script>