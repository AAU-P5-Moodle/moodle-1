import Templates from "core/templates";

// This will be the context for our template. So {{name}} in the template will resolve to "Tweety bird".
const context = {
  name: "Tweety bird",
  intelligence: 2,
};

export const init = async () => {
  // This will call the function to load and render our template.
  Templates.renderForPromise("mod_livequiz/question_menu_popup", context)

    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here eventually I have my compiled template, and any javascript that it generated.
      // The templates object has append, prepend and replace functions.
      Templates.appendNodeContents(".main-container", html, js);
    })

    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
};
