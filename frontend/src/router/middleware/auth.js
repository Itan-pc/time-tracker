export default async function auth({ next, store }) {
  if (!store.getters.auth.isAuthorized) {
    await store.dispatch("refreshToken").catch(() => {
      next({
        name: "login"
      });
    });
  }

  return next();
}
