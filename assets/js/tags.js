window.tagInput = function (initial) {
    return {
        tags: initial ? initial.split(',').filter(t => t.length) : [],
        newTag: '',

        addTag() {
            let tag = this.newTag.trim();
            if (tag !== '' && !this.tags.includes(tag)) {
                this.tags.push(tag);
            }
            this.newTag = '';
        },

        removeTag(index) {
            this.tags.splice(index, 1);
        },

        get serialized() {
            console.log(this.tags);
            return this.tags.join(',');
        }
    }
}

