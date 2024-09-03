import '../css/app.css';
import 'primeicons/primeicons.css'

import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import Main from './layouts/welcome/Main.vue';
import Header from './layouts/welcome/Header.vue';
import Footer from './layouts/welcome/Footer.vue';
import Dashboard from './layouts/dashboard/Main.vue';
import MainCard from './layouts/dashboard/MainCard.vue';
import TrainingPlan from './layouts/trainingPlans/TrainingPlans.vue';
import NewTrainingPlan from "./layouts/trainingPlans/NewTrainingPlan.vue";
import AllUsers from "./layouts/users/AllUsers.vue";
import AllTrainers from "@/layouts/trainers/AllTrainers.vue";
import Login from "@/layouts/auth/Login.vue";
import Register from "@/layouts/auth/Register.vue";
import Details from "@/layouts/trainingPlans/Details.vue";
import Schedule from "@/layouts/Schedule/Schedule.vue";
import Profile from "@/layouts/trainers/Profile.vue";
import AllNotifications from "@/layouts/notification/AllNotifications.vue";
import GlobalList from "@/layouts/trainingPlans/GlobalList.vue";
import theme from 'tailwindcss/defaultTheme';

import Menubar from 'primevue/menubar';
import Button from "primevue/button"
import MegaMenu from 'primevue/megamenu';
import Panel from 'primevue/panel';
import Drawer from 'primevue/drawer';
import InputText from 'primevue/inputtext';
import Avatar from 'primevue/avatar';
import Card from 'primevue/card';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional
import AvatarGroup from 'primevue/avatargroup';   //Optional for grouping
import FloatLabel from 'primevue/floatlabel';
import Textarea from 'primevue/textarea';
import Select from 'primevue/select';
import InputNumber from 'primevue/inputnumber';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import TreeTable from 'primevue/treetable';
import Stepper from 'primevue/stepper';
import StepList from 'primevue/steplist';
import StepPanels from 'primevue/steppanels';
import StepItem from 'primevue/stepitem';
import Step from 'primevue/step';
import StepPanel from 'primevue/steppanel';
import PickList from 'primevue/picklist';
import Listbox from 'primevue/listbox';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import Password from 'primevue/password';
import Divider from 'primevue/divider';
import ToggleButton from 'primevue/togglebutton';
import FileUpload from 'primevue/fileupload';
import Image from 'primevue/image';
import DataView from 'primevue/dataview';
import Tag from 'primevue/tag';
import Checkbox from 'primevue/checkbox';

const app = createApp({});

app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.component('main-component', Main);
app.component('header-component', Header);
app.component('footer-component', Footer);
app.component('dashboard-component', Dashboard);
app.component('main-component', Main);
app.component('card-component', MainCard);
app.component('training-plans-component', TrainingPlan);
app.component('global-training-plans-component', GlobalList);
app.component('new-training-plan-component', NewTrainingPlan);
app.component('all-users', AllUsers);
app.component('all-trainers', AllTrainers);
app.component('login-component', Login);
app.component('register-component', Register);
app.component('training-plan-details-component', Details);
app.component('schedule-component', Schedule);
app.component('trainer-profile-component', Profile);
app.component('notifications-component', AllNotifications);

app.component('Panel', Panel);
app.component('Button', Button);
app.component('MegaMenu', MegaMenu);
app.component('Menubar', Menubar);
app.component('Drawer', Drawer);
app.component('InputText', InputText);
app.component('Avatar', Avatar);
app.component('Card', Card);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('CarColumnGroup', ColumnGroup);
app.component('Row', Row);
app.component('AvatarGroup', AvatarGroup);
app.component('Toast', Toast);
app.component('ToastService', ToastService);
app.component('FloatLabel', FloatLabel);
app.component('Textarea', Textarea);
app.component('Select', Select);
app.component('InputNumber', InputNumber);
app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('Stepper', Stepper);
app.component('StepList', StepList);
app.component('StepPanels', StepPanels);
app.component('StepItem', StepItem);
app.component('Step', Step);
app.component('StepPanel', StepPanel);
app.component('TreeTable', TreeTable);
app.component('PickList', PickList);
app.component('Splitter', Splitter);
app.component('SplitterPanel', SplitterPanel);
app.component('Password', Password);
app.component('Listbox', Listbox);
app.component('Divider', Divider);
app.component('ToggleButton', ToggleButton);
app.component('FileUpload', FileUpload);
app.component('Image', Image);
app.component('DataView', DataView);
app.component('Tag', Tag);
app.component('Checkbox', Checkbox);

app.mount("#app");
