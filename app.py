import flask
from flask import redirect
from flask import session
from flask import url_for

import data

app = flask.Flask(__name__, static_folder='./KMS', template_folder='./KMS/templates',
                  static_url_path='', instance_relative_config=True)
app.config.from_object('config')
#app.config.from_pyfile('config.py')

database = data.DB()

@app.route('/')
def dashboard():
    return flask.render_template('index.html')

@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))

@app.route('/login')
@app.route('/login/<string:user>')
def login(user='teacher'):
    if 'user' in session:
        return redirect(url_for('dashboard'))
    text = {'usertext': 'Username', 'passwordtext': 'Password'}
    if (user=='teacher'):
        pass
    elif(user=='parent'):
        text['usertext'] = 'MyKidID'
        text['passwordtext'] = 'Parent IC No.'

    return flask.render_template('login.html', login=text, usertype=user)

@app.route('/userverify', methods=['POST', 'GET'])
def user_verify():
    req = flask.request.form
    ret = {'success': False}
    ret['text'] = 'Login fail!!'
    if req['usertype']=='teacher':
        user = database.teacher_authen(req['username'],req['password'])
    else:
        user = database.parent_authen(req['username'], req['password'])
    if user:
        session['user'] = user
        ret['success'] = True
        ret['text'] = 'Successful'

    return flask.jsonify(ret)

#render for template testing
@app.route('/render/<string:filename>')
def render(filename='index.html'):
    return flask.render_template(filename)


if __name__ == '__main__':
    app.run(port=8080)

