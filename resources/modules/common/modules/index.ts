/**
 * This file is a part of the Bloggi CMS.
 *
 * @author Lilian
 */
// TBD

export interface Module {
    onInit?(): void;
    onDomLoad?(): void;
}

/**
 * This function starts the module and calls all lifecycle events.
 */
export const startModule = (module: Module) => {
    // onInit
    module.onInit?.();

    // onDomLoad
    document.addEventListener("DOMContentLoaded", function () {
        module.onDomLoad?.();
    })
}