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

def login_require(session):
    if 'user' in session:
        return False
    else:
        session.clear()
        return True


@app.route('/')
def dashboard():
    if login_require(session):
        return redirect(url_for('login'))

    if not 'data' in session:
        data = {}
        data['headteacher'] = data['teacher'] = data['parent'] =False

        if 'usertype' in session:
            if session['usertype']=='teacher':
                data['teacher'] = True
                if 'user' in session:
                    data['headteacher'] = session['user'][0]['HeadTeacher']
            else:
                data['parent']=True
        session['data'] = data
    else:
        data = session['data'][0]

    return flask.render_template('index.html', data=data)


@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))


@app.route('/login')
@app.route('/login/<string:user>')
def login(user='teacher'):
    if 'user' in session:
        return redirect(url_for('dashboard'))
    data = {'usertext': 'Username', 'passwordtext': 'Password'}
    if (user=='teacher'):
        data['toggle_url'] = '/login/parent'
        data['who'] = 'Parent'
        pass
    elif(user=='parent'):
        data['usertext'] = 'MyKid No.'
        data['passwordtext'] = 'Parent IC No.'
        data['toggle_url'] = '/login'
        data['who'] = 'Teacher'
    session['usertype'] = user
    data['usertype'] = user

    return flask.render_template('login.html', data=data)


@app.route('/userverify', methods=['POST', 'GET'])
def user_verify():
    req = flask.request.form
    ret = {'success': False}
    ret['text'] = 'Login fail!!'
    if req['usertype']=='teacher':
        user = database.teacher_authen(req['username'],req['password'])
        session['usertype'] = 'teacher'
    else:
        user = database.parent_authen(req['username'], req['password'])
        session['usertype'] = 'parent'
    if user:
        session['user'] = user
        ret['success'] = True
        ret['text'] = 'Successful'

    return flask.jsonify(ret)


@app.route('/student/profile')
def student_profile():
    data = {}
    if 'data' in session:
        data = session['data']

    return flask.render_template('Createstudentprofile.html', data=data)


#render for template testing
@app.route('/render/<string:filename>')
def render(filename='index.html'):
    return flask.render_template(filename)


if __name__ == '__main__':
    app.run(port=8080)

