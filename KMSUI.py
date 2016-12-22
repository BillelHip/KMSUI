from flask import Flask, redirect, url_for, render_template
#from jinja2 import Environment, PackageLoader

app = Flask(__name__, static_folder='./KMS', template_folder='./KMS/templates', static_url_path='')

@app.route('/')
def dashboard():
    return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True, port=8080)

