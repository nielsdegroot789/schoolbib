export default function ({ store, redirect }) {
  if (!store.state.JWT) {
    return redirect('/login');
  }
}
