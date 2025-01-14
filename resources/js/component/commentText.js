import { LitElement, html} from "lit";

export class CommentText extends LitElement {
    static get properties() {
        return {

            content: { type: Object }
        };
    }

    constructor(props) {
        super(props);
    }


    render() {
        console.log(this.content.value);
    return html`
        
            <p slot="comment">${this.content.value}</p>
        
    `;
  }
}

customElements.define('comment-text', CommentText);