import { usePage } from "@inertiajs/vue3"

export default {
    install: (app) => {
      // inject a globally available $translate() method
      app.config.globalProperties.$feature = (feature) => {

       const app_settings = usePage().props.settings;

        if(feature === true){
            return true
        }

        if (typeof(feature) === "string") {
            const found = app_settings[feature]
            return (found) ? found : false
        }

        if (typeof(feature) === "object"){
            return feature.filter(e => app_settings.includes(e)).length > 0 ? true: false
        }

        return false

      }
    }
  }
