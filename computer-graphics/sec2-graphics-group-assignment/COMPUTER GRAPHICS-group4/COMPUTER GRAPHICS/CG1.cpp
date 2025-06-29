#include <GL/glut.h>

void display() {
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();

    // Draw wireframe grid
    glColor3f(1.0, 1.0, 1.0); // Set color to white
    glBegin(GL_LINES);
    for (int i = -5; i <= 5; i++) {
        glVertex3f(i, 0, -5);
        glVertex3f(i, 0, 5);
        glVertex3f(-5, 0, i);
        glVertex3f(5, 0, i);
    }
    glEnd();

    // Draw pyramid structure
    glBegin(GL_TRIANGLES);
    // Front face
    glColor3f(1.0, 0.0, 0.0); // Red
    glVertex3f(0, 1, 0);
    glVertex3f(-1, 0, 1);
    glVertex3f(1, 0, 1);

    // Other faces with different colors
    // Add color gradients as needed

    glEnd();

    glutSwapBuffers();
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_RGB | GLUT_DOUBLE | GLUT_DEPTH);
    glutCreateWindow("3D Graphics");
    glutDisplayFunc(display);
    glEnable(GL_DEPTH_TEST);

    glutMainLoop();

    return 0;
}