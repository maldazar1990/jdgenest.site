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
    return html`
        
            <p slot="comment">${this.content.value}</p>
        
    `;
  }
}

customElements.define('comment-text', CommentText);