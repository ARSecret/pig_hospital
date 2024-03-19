export class ApiObject {
    addLazyProperty(name, loadFunction) {
        let underscored = '_' + name;
        this[underscored] = null;
        Object.defineProperty(this, name, {
            get() {
                if (this[underscored] === null) {
                    this[underscored] = await loadFunction();
                }

                return this[underscored];
            }
        });
    }
}