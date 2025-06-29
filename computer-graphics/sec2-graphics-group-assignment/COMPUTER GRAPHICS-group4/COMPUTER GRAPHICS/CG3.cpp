#include <GL/glut.h>

void display() {
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);
    glLoadIdentity();

    // Draw geometric shapes
    // Red square
    glColor3f(1.0, 0.0, 0.0); // Red color
    glBegin(GL_QUADS);
    glVertex2f(-0.5, 0.5);
    glVertex2f(0.0, 0.5);
    glVertex2f(0.0, 0.0);
    glVertex2f(-0.5, 0.0);
    glEnd();

    // Yellow hexagon
    // Add code to draw the yellow hexagon

    // Green square
    // Add code to draw the green square

    // Gray gradient square
    // Add code to draw the gray gradient square

    // Blue triangle
    // Add code to draw the blue triangle

    // Triangle with rainbow gradient
    // Add code to draw the triangle with rainbow gradient

    glutSwapBuffers();
}

int main(int argc, char** argv) {
    glutInit(&argc, argv);
    glutInitDisplayMode(GLUT_RGB | GLUT_DOUBLE | GLUT_DEPTH);
    glutCreateWindow("Geometric Shapes");
    glutDisplayFunc(display);
    glEnable(GL_DEPTH_TEST);

    glutMainLoop();

    return 0;
}