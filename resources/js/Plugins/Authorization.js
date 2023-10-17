import { usePage } from "@inertiajs/vue3"

export default {
    install: (app) => {
      // inject a globally available $translate() method
      app.config.globalProperties.$authorize = (role) => {

       const user_permissions = usePage().props.user_permissions;

        if(role === true){
            return true
        }

        if (typeof(role) === "string") {
            return (user_permissions.indexOf(role) >= 0) ? true : false
        }

        if (typeof(role) === "object"){
            return role.filter(e => user_permissions.includes(e)).length > 0 ? true: false
        }

        return false

      }
    }
  }
