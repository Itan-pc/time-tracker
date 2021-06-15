export default function guest({ next, store }) {
  if (store.getters.auth.isAuthorized) {
    next({
      name: "home"
    });
  }

  return next();
}
