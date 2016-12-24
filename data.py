from tinydb import TinyDB, Query

class DB:

    db = TinyDB('db.json')
    table_teacher = db.table('Teacher')
    table_parent = db.table('Parent')
    table_student = db.table('Student')

    def __init__(self):
        q = Query()
        teacher = self.table_teacher.search(q.ID==0)
        if len(teacher)==0:
            self.table_teacher.insert({
                'ID': 0,
                'FullName': 'Super Admin',
                'Username': 'admin',
                'Password': 'ADMIN',
                'HeadTeacher': True
            })
        elif len(teacher[0].keys())<5:
            self.table_teacher.update({
                'ID': 0,
                'FullName': 'Super Admin',
                'Username': 'admin',
                'Password': 'ADMIN',
                'HeadTeacher': True
            }, q.ID==0)

    def teacher_authen(self,username, password):
        q = Query()
        teacher = self.table_teacher.search((q.Username == username) & (q.Password == password))
        ret = {}
        if len(teacher):
            ret = teacher

        return ret

    def parent_authen(self, mykidID, parentIC):
        q = Query()
        parent = self.table_parent.search((q.StudentID == mykidID) & (q.ParentID == parentIC))
        ret = {}
        if len(parent):
            ret = parent

        return ret



