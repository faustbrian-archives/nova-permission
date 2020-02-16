import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting(Vue => {
    Vue.component('index-FieldPermissions', IndexField);
    Vue.component('detail-FieldPermissions', DetailField);
    Vue.component('form-FieldPermissions', FormField);
});
