import pygame
import sys

pygame.init()

screen_width = 800
screen_height = 600
screen = pygame.display.set_mode((screen_width, screen_height))
pygame.display.set_caption("Bille rebondissante")

red = (255, 0, 0)
black = (0, 0, 0)

ball_radius = 20
ball_x = screen_width // 2
ball_y = screen_height // 2
ball_speed_x = 5
ball_speed_y = 5

clock = pygame.time.Clock()
while True:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            pygame.quit()
            sys.exit()

    
    ball_x += ball_speed_x
    ball_y += ball_speed_y
    if ball_x - ball_radius <= 0 or ball_x + ball_radius >= screen_width:
        ball_speed_x = -ball_speed_x
    if ball_y - ball_radius <= 0 or ball_y + ball_radius >= screen_height:
        ball_speed_y = -ball_speed_y

    screen.fill(black)
    pygame.draw.circle(screen, red, (ball_x, ball_y), ball_radius)
    pygame.display.flip()

    clock.tick(60)