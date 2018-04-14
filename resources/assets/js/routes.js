import VueRouter from "vue-router";
import Dashboard from "./components/admin/Dashboard";
import Tides from "./components/admin/Tides";
//import Dams from "./components/admin/Dams";
import Chat from "./components/admin/Chat";
import RightNow from "./components/user/RightNow";
import SendReport from "./components/user/SendReport";
import ReportTest from "./components/admin/ReportTest";
import Assign from "./components/admin/Assign";
import AddTeams from "./components/admin/AddTeams";
import AccessControl from "./components/admin/AccessControl";

const routes = [
  {
    path: "/administrator",
    component: ReportTest
  },
  {
    path: "/tides",
    component: Tides
  },
  {
    path: "/chat",
    component: Chat
  },
  {
    path: "/weather",
    component: Dashboard
  },
  {
    path: "/",
    component: RightNow
  },
  {
    path: "/send",
    component: SendReport
  },
  {
    path: "/assign",
    component: Assign
  },
  {
    path: "/teams",
    component: AddTeams
  },
  {
    path: "/settings",
    component: AccessControl
  }
];
export default new VueRouter({
  routes,
  mode: "history"
});
