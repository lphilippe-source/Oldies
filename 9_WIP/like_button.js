'use strict';

const e = React.createElement;
console.log(e);
class LikeButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }
//methode du component
  render() {
    if (this.state.liked) {
      return 'You liked this.';
    }

    return e(
      'button',
      { onClick: () => this.setState({ liked: true }) },
      'Like'
    );
  }
}
const domContainer = document.querySelector('#like_button_container');
//methode de reactDOM
ReactDOM.render(e(LikeButton), domContainer);