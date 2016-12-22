from flask import Flask, redirect, url_for, render_template, request, jsonify

import json

app = Flask(__name__, static_folder='./KMS', template_folder='./KMS/templates', static_url_path='')

@app.route('/')
def dashboard():
    return render_template('index.html')

@app.route('/login')
@app.route('/login/<string:user>')
def login(user='teacher'):
    text = {}
    text = {'usertext': 'Username', 'passwordtext': 'Password'}
    if (user=='teacher'):
        pass
    elif(user=='parent'):
        text['usertext'] = 'MyKidID'
        text['passwordtext'] = 'Parent IC No.'

    return render_template('login.html', login=text)

@app.route('/userverify', methods=['POST', 'GET'])
def user_verify():
    req = request.form
    ret = {'success': True}
    ret.update({'text': req['username']+' '+req['password']})
    return jsonify(ret)



if __name__ == '__main__':
    app.run(debug=True, port=8080)

