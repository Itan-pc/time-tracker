import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import Login from "../views/Login";
import auth from "./middleware/auth";
import guest from "./middleware/guest";
import store from "../store";
import middlewarePipeline from "./middlewarePipeline";
import Register from "../views/Register";
import CreateTask from "../views/CreateTask";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
    meta: {
      middleware: [auth]
    }
  },
  {
    path: "/login",
    name: "login",
    component: Login,
    meta: {
      middleware: [guest]
    }
  },
  {
    path: "/register",
    name: "register",
    component: Register,
    meta: {
      middleware: [guest]
    }
  },
  {
    path: "/task/add",
    name: "task.add",
    component: CreateTask,
    meta: {
      middleware: [auth]
    }
  },
  {
    path: "/task/:id/edit",
    name: "task.edit",
    component: CreateTask,
    meta: {
      middleware: [auth]
    }
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  if (!to.meta.middleware) {
    return next();
  }
  const middleware = to.meta.middleware;

  const context = {
    to,
    from,
    next,
    store
  };

  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1)
  });
});

export default router;
