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
        data = session['data']

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
    if login_require(session):
        return redirect(url_for('login'))
    if 'data' in session:
        data = session['data']
    else:
        data = {}

    return flask.render_template('Createstudentprofile.html', data=data)


@app.route('/student/profile/create', methods=['POST'])
def student_profile_create():
    ret = {'success': False}

    if login_require(session):
        ret = {'text': 'Login require'}
        return flask.jsonify(ret)

    req = flask.request.form

    return flask.jsonify(ret)


@app.route('/event')
def event():
    if login_require(session):
        return redirect(url_for('login'))
    if 'data' in session:
        data = session['data']
    else:
        data = {}

    return flask.render_template('ManageEvents.html', data=data)

@app.route('/event/json')
def event_json():
    #if login_require(session):
    #    return redirect(url_for('login'))
    ret=database.get_events()

    return flask.jsonify(ret)


@app.route('/event/add', methods=['POST', 'GET'])
def event_add():
    req = flask.request.form
    ret = {'success': False}
    #ret['text'] = 'Update fail!!'
    subject = date = description = ''
    year1 = year2 = year3 = False
    if 'Subject' in req:
        subject = req['Subject']
    if 'Date' in req:
        date = req['Date']
    if 'Description' in req:
        description = req['Description']
    if 'Year4' in req:
        year4 = True
    if 'Year5' in req:
        year5 = True
    if 'Year6' in req:
        year6 = True

    ret['success'] = database.add_events(subject,date,description,year4,year5,year6)

    return flask.jsonify(ret)


@app.route('/event/list/html')
def event_list_html():
    #if login_require(session):
    #    return redirect(url_for('login'))
    event=database.get_events()
    html = ''
    for i in event:
        html = html + '<div class=\"panel panel-default\"><div class=\"panel-heading\">Events</div><div class=\"panel-body\">'
        html = html + '<div class=\"form-group\"><label>Subject</label><p class=\"form-control-static\"></p>'+ i['Subject'] +'</div>'
        html = html + '<div class=\"form-group\"><label>Date</label><p class=\"form-control-static\"></p>'+ i['Date'] +'</div>'
        html = html + '<div class=\"form-group\"><label>'
        if i['Year4']:
            html = html + 'Year4 '
        if i['Year5']:
            html = html + 'Year5 '
        if i['Year6']:
            html = html + 'Year6'

        html = html + '</label></div>'

        html = html + '<div class=\"form-group\"><label>Description</label><p class=\"form-control-static\"></p>'+ i['Description'] +'</div>'

        html = html + '</div></div>'

    return html


@app.route('/course')
def course():
    if login_require(session):
        return redirect(url_for('login'))
    if 'data' in session:
        data = session['data']
    else:
        data = {}

    return flask.render_template('ManageCourses.html', data=data)



#render for template testing
@app.route('/<string:filename>')
@app.route('/render/<string:filename>')
def render(filename='index.html'):
    if 'data' in session:
        data = session['data']
    else:
        data = {}
    return flask.render_template(filename, data=data)


if __name__ == '__main__':
    app.run(port=8080)

