export function currentRoute(action, routeName = null) {
  if (routeName) {
    return routeName + '.' + action;
  }
  return route().current().replace(/(index|create|edit|show)/, action);
}
